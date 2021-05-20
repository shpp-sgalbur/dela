<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class Categories extends Component
{
    public $categories;
    public $currentcategory;
    //public $categorypaginator;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($currentcategory=null)
    {
        //dd($currentcategory);
        $allcategories=Category::where('owner_id',Auth::id());
        //$this->categories= Category::all();
        
        $this->categories=$allcategories->paginate(3);
        
        //$this->categories=$this->categories->get();
        if($currentcategory==null){
            $this->currentcategory = $allcategories->first();
        }else{
            
            $this->currentcategory = $currentcategory;
        }

        //$this->currentcategory = $this->categories
        
        //dd($this->current_category);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.categories',['currentcategory'=> $this->currentcategory]);
    }
}
