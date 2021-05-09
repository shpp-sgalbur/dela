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
        if($category==null){
            $category= Category::where('owner_id',Auth::id())->first();
            if($category==null){
                return 'находим все дела категории данного пользователя ';
            }else{
                $this->category = $category;
                $this->deals = Deal::where('category_id', $this->category->id)->paginate(10);
                if($this->deals != null){
                    return view('showCategory',['category'=>$this->category,'deals'=> $this->deals]);
                }
                
                
            }
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
