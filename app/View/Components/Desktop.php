<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Desktop extends Component
{
    public $mode;
    public $category;
    public $active ;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($active ='Главная')
    {
        $this->active =$active ;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.desktop');
    }
}
