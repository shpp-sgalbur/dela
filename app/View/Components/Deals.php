<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Deal;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class Deals extends Component
{
    public $deals;
    public $category;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($category=null)
    {
        if(Auth::id()){
             if($category==null){
            
            $category= Category::where('owner_id',Auth::id())->first();
            if($category==null){
                echo 'У вас еще не создано ни одной категории';
            }
            
        }
         
                $this->category = $category;
                //dd($this->category->id);
                $this->deals = Deal::where('category_id', $this->category->id)->orderBy('rating','desc')->paginate(4,['*'],'dealPage')->withQueryString();
        }
        
       
                
        
        
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.deals');
    }
    
}
