<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Category;
use App\Models\Deal;

class DealComp extends Component
{
    public $deal;
    public $category;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Deal $deal)
    {
        //dd($deal);
        $this->deal = $deal;
        $this->category = Category::where('id',$deal->category_id)->first();
        
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.deal-comp');
    }
}
