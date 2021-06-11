<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Deal;
use App\Models\Category;

include __DIR__.'/../../curl/curl.php';

class DealController extends Controller
{
    public $currentcategory;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($currentcategory=null)
    {
        //echo 'controller'.$currentcategory.'deal'; 
        $this->currentcategory=$currentcategory;
        return view('components.supermain', ['active'=>'Добавить дело', 'mode' =>'createDeal','currentcategory'=>$currentcategory]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $category)
    {
        $deal = new Deal;
        $deal->content = $request->input('deal');
        if($deal->content !=''){        
            $strUrl = getUrlFromStr($deal->content);
            if($strUrl!=''){
                $title = titleAsLink($strUrl);
                if($title!=''){
                    $deal->content = str_replace($strUrl, $title  , $deal->content);
                }else{
                    $deal->content = str_replace($strUrl, "<a href ='$strUrl'>$strUrl</a>"  , $deal->content);
                }


            }
            $deal->votes = 0;
            $deal->rating=500;
            $deal->category_id=$category->id;
            $deal->history = '';
            $deal->save(); 
            return view('showCategory',['currentcategory'=>$category,'active'=>'Добавить дело','mode'=>'ShowCategory']);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        
        $deal = Deal::find($id);
        
        $category = \App\Models\Category::where('id',$deal->category_id)->first();
        //dd($category);
        //return view('components.form-edit-deal',['deal'=>$deal,'currentcategory'=>$category]);
        //dd($slot);
        return view('components.supermain',['active'=>'Редактировать дело','mode'=>'EditDeal', 'currentcategory'=>$category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $deal = Deal::find($id);
        
        $deal->content = $request->input('deal');
        $deal->save();
        $category = Category::find($deal->category_id);
        
        return view('components.supermain',['active'=>'Главная','mode'=>'ShowCategory',
               'currentcategory'=>$category]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $category)
    {
        
       
        Deal::where('id', $id)->delete();
        return redirect()->route('category.show',['currentcategory'=>$category,'active'=>'Главная','mode'=>'ShowCategory','id'=>$id, 'category'=>$category]);
    }
    
    public function voteCreate(\App\Models\Category $category) {
        
       
        return view('components.supermain',['active'=>'Расставить приоритеты','mode'=>'Vote','currentcategory'=>$category]);
    }
    
    public function voteStore( \App\Models\Category $category, Deal $winDeal, Deal $loserDeal){
        DB::transaction(function () use ($winDeal, $loserDeal){
            
            $a=$winDeal->rating;
            $b=$loserDeal->rating;
            $s1=1;
            $s2=0;
            $q1=$winDeal->votes;
            $q2=$loserDeal->votes;
            //Пересчитывем  рейтинги вопросов
            $ra=$winDeal->rating= $this->r_elo($a, $b, $s1, $q1);
            $rb=$loserDeal->rating= $this->r_elo($b, $a, $s2, $q2);

            $winDeal->votes++;
            $loserDeal->votes++;

            //Формируем строку дополнения истории голосования
            $difference1 = $a - $ra;
            $difference2 = $b - $rb;
            $add_history1 = $loserDeal->id.':'.$difference1;
            $add_history2 = $winDeal->id.':'.$difference2;

            $winDeal->history = strlen($winDeal->history)>0 ? $winDeal->history.','.$add_history1 : $add_history1;
            $loserDeal->history = strlen($loserDeal->history)>0 ? $loserDeal->history.','.$add_history2 : $add_history2;
            $winDeal->save();
            $loserDeal->save();
            
            
        });
        session()->push("votes_arr.$winDeal->category_id",$winDeal->id.'-'.$loserDeal->id);
        dump(session('votes_arr'));
        return view('components.supermain',['active'=>'Расставить приоритеты','mode'=>'Vote','currentcategory'=>$category]);
        
        
    }
    private function r_elo($Ra,$Rb,$Sa,$q){
        // $Sa- Если первый игрок выиграл =1, если первый проиграл=0, если ничья =0.5
        //$q -количество игр (голосований). Е
        //определяем математическое ожидание
        $E=1/(1+ pow(10,(($Rb-$Ra)/400)));
        //$E=1/(1+ (10*($Rb-$Ra)/400));
         //Определяем коэффициент
                If($Ra>=2400){
                 $K=10;
                 }	 
        Else{	 
         $K=15;	 
        }//End If


                If($q<30){
                 $K=30;
        }//End If


        $Ra=  round($Ra+$K*($Sa-$E));
         Return $Ra;
    }
}
