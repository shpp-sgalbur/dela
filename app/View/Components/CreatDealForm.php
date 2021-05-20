<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CreatDealForm extends Component
{
    public $currentcategory;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($currentcategory)
    {
        $this->currentcategory=$currentcategory;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.creat-deal-form');
    }
}
