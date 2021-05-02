<?php

namespace App\View\Components;

use Illuminate\View\Component;


class Category extends Component
{
    public $category;
    public $id;
    public $owner_id;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct( $category)
    {
        $this->category = $category;
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
