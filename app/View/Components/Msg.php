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
        //dd($request);
        //dd($request->deal);
        if($request->msg){
            if(isset($request->category)){
                $value = $request->category;
                
            }
            if(isset($request->deal)){
                $value = $request->deal;
               //dd($value);
            }
            $highlightedValue = "<b><i>$value</b></i>";
            $this->msg = str_replace($value, $highlightedValue, $request->msg);
            //dd($this->msg);
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
