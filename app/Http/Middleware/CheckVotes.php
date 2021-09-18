<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Category;

class CheckVotes
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        
               
        $url=$request->fullUrl();        
        $category_id = substr($url, strrpos($url, '/') + 1);
        
        
        if($request->session()->has("countvote")){
            $arr = $request->session()->get("countvote");
            //var_dump($arr);
            if(!isset($arr[$category_id])){
                //dump($category_id);
                //dd($request);
                $request->session()->forget("countvote");
                $request->session()->push("countvote.$category_id", 3);
            }
            
          
        }else{
            $request->session()->push("countvote.$category_id", 3);
            
        }
        $n = session("countvote.$category_id.0");
        
        if(session("countvote.$category_id.0") > 0){
//            
           session(['mode' => 'preCreateDeal']);
            //dd(session());
            return redirect()->route('voteCreate',['category'=>$category_id,'msg'=>null,'mode'=>'preCreateDeal','n'=>$n]);
        }else{
            session(['mode' => 'createDeal']);
            return $next($request);
        }
        //return $next($request);
    }
}
