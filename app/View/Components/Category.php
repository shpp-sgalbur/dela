<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Deal;


class Category extends Component
{
    public $category;
    public $id;
    public $owner_id;
    public $empty;
    public $linkDelButton;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct( $category=null)
    {
        
        $this->category = $category;
        //по идентификатору категории получаем первое дело в категории
        $empty = Deal::where('category_id', $category->id)->first();
        if($empty === null){
            $this->empty = true;
            $this->linkDelButton = route('category.destroy',['category'=>$category]);
            
            
        }
        else{
            $this->empty = false;
            $this->linkDelButton = route('proveDel',['category'=>$category]);
            
        }
        
        
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.category');
    }
}
