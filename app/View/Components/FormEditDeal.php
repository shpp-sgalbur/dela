<?php

namespace App\View\Components;

use Illuminate\Http\Request;
use Illuminate\View\Component;
use App\Models\Deal;
use App\Models\Category;

class FormEditDeal extends Component
{
    public $deal;
    public $currentcategory ;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        //dump($request);
        $deal_id = $request->id;
        $this->deal = $deal = Deal::find($deal_id);
        
        $this->currentcategory  = $category = \App\Models\Category::where('id',$deal->category_id)->first();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.form-edit-deal');
    }
}
