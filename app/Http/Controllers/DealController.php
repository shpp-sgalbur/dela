<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Deal;
use App\Models\Category;

include __DIR__.'/../../curl/curl.php';
include __DIR__.'/../../delete_hit.php';

class DealController extends Controller
{
    public $currentcategory;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $msg=null)
    {
       
        //dd($request);
        $category = Category::find($request->category);
        //
        return view('components.supermain',
                [
                    'currentcategory'=>$category,
                    'active'=>"Главная", 
                    'mode'=>'ShowCategory',
                    'msg'=>$msg  
                ]);
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
        return view('components.supermain', ['active'=>'Добавить дело', 'mode' =>'createDeal','currentcategory'=>$currentcategory, 'msg'=>null]);
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
        $request->session()->reflash('deal',$deal->content);
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
            
            
            
            $transaction = DB::transaction(function () use($category, $deal) {
                
                $arr_deal_ids = explode(',', $category->deals);
                $deal->save(); 
                $arr_deal_ids[] = $deal->id;
                $category->deals = implode(',', $arr_deal_ids);
                
                $category->save();
                return true;
            });
            if($transaction){
                $msg = "Дело $deal->content успешно добавлено";
            }else{
                $msg = "Что-то пошло не так";
            }
            session(['deal' => $deal->content]);
            return redirect()->route('category.show',['category'=>$category,'msg'=>$msg]);
            
            return view('components.supermain',['currentcategory'=>$category,'active'=>'Добавить дело','mode'=>'ShowCategory','msg'=>$msg]);
        }
        
    }
    public function find($category){
        
        return view('components.supermain',['currentcategory'=>$category,'active'=>'Поиск','mode'=>'Found','msg'=>null]);
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
        return view('components.supermain',['active'=>'Редактировать дело','mode'=>'EditDeal', 'currentcategory'=>$category, 'msg'=>null]);
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
               'currentcategory'=>$category, 'msg'=>null]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id, $category)
    {
       
        $deal = Deal::find($id)->content;
        //dd($deal);
        $request->session()->reflash('deal',$deal);
        
        $transaction = DB::transaction(function () use($category, $id){
            
            delete_hit($id);
            
            Deal::where('id', $id)->delete();
            
           
            
            
            
            $arr_deal_ids = explode(',', $category->deals);
            $key = array_search($id, $arr_deal_ids);
            unset($arr_deal_ids[$key]);
            $category->deals = implode(',', $arr_deal_ids);
            
            $category->save();
            return true;
        });
        if(isset($transaction)){
           // dd($transaction);
                $msg = "Дело $deal успешно удалено";
               
            }else{
                //dd($transaction);
                $msg = "Что-то пошло не так, дело не было удалено";
            }
            session(['deal' => $deal]);
       
        return redirect()->route('category.show',['category'=>$category,'msg'=>$msg]);
        
        
//        return view('components.supermain',[
//            'currentcategory'=>$category,
//            'active'=>'Главная',
//            'mode'=>'ShowCategory',
//            'id'=>$id, 
//            'category'=>$category, 
//            'msg'=>$msg,
//            
//        ]);
    }
    
    public function voteCreate(\App\Models\Category $category, Request $request) {
        
        $msg = $request->msg;
        $mode = $request->mode;
        if($mode==null) $mode = 'Vote';
        
       
        return view('components.supermain',['active'=>'Расставить приоритеты','mode'=>$mode,'currentcategory'=>$category, 'msg'=>$msg]);
    }
    
    public function voteStore( \App\Models\Category $category, Deal $winDeal, Deal $loserDeal, Request $request){
        
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
//        $n=session('countvote')[0]-1;
//        session(['countvote'=>$n]);
        session(["countvote.$category->id.0"=>session("countvote.$category->id.0")-1]);
        
        //dump(session("countvote.$category->id.0"));
        $mode = $request->mode;
        //dd($mode);
        return view('components.supermain',['active'=>'Расставить приоритеты','mode'=>"$mode",'currentcategory'=>$category, 'msg'=>null]);
        
        
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
    
//    function delete_hit($id_del) {
//        global $history_matr;
//        
//        $story = $this->getHistory($id_del);
//        if($story){
//            $history_matr[$id_del]['history'] = $story;
//            $pos=0;
//        }
//        dump('delete_hit');
//        dd($story);
//        
//    }
//    
//    function getHistory($id){
//        
//        $hit = $this->getHit($id);   
//
//        $resArr = NULL;
//        if($hit->history !=''){
//            $votes = explode(',', $hit->history);
//            
//            foreach ($votes as $pos => $vote) {
//                $vote_items = explode(':', $vote);  
//                $resArr[$pos]['pare_id'] = $vote_items[0];
//                $resArr[$pos]['pare_chang'] = $vote_items[1];
//            }        
//        }
//
//        
//        return $resArr;
//    }
//    
//    function getHit($id){
//        
//        
//    return Deal::find($id);
//    
//}
}

