<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Deal;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Msg extends Component
{
    public $msg;
    /**
     * Create a new component instance.
     *выделяет в сообщении $msg строку $value 
     * @return void
     */
    public function __construct($msg=null, Request $request, Response $respons)
    {
        
//        dump($request->session());
    // dump(session('deal'));
//        dd($respons);
        //dump($request);
        if($request->msg){
            if(session('category')!==null){
                $value = session('category');
                
            }
            if(session('deal')!==null){
                $value = session('deal');
               //dd($value);
            }
            $highlightedValue = "<i><b class='text-4xl'>$value</i></b>";
            $this->msg = str_replace($value, $highlightedValue, $request->msg);
           // dd($this->msg);
        }else{
            $this->msg=null;
        }
        
        
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.msg');
    }
}
