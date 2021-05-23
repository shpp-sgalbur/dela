<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deal;

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
        return view('newDealForm', ['active'=>'Добавить дело', 'mode' =>'createDeal','currentcategory'=>$currentcategory]);
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
            $deal->rating=500;
            $deal->category_id=$category->id;
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
    public function edit($id)
    {
        //
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
        //
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
        return view('showCategory',['currentcategory'=>$category,'active'=>'Главная','mode'=>'ShowCategory','id'=>$id, 'category'=>$category]);
    }
}
