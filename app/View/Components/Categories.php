<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Category;

class Categories extends Component
{
    public $categories;
    public $currentcategory;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($currentcategory=null)
    {
        //dd($current_category);
        $this->categories = Category::paginate(10);
        $this->currentcategory = $currentcategory;
        //dd($this->current_category);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.categories');
    }
}
