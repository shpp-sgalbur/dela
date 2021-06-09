<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Vote extends Component
{
    public $category;
    public $dealpair=[];
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($category)
    {
        $this->category = $category;
        $deals_count = Deal::where('category_id',$category->id)->count();
        if($deals_count > 1){
            $votes_arr=array();
            $unic_para=false;
            $deals=Deal::where('category_id',$category->id)->orderBy('votes', 'asc')->orderBy('rating', 'asc')->get();
            foreach ($deals as $deal){
                
                
            }
            //dump($deals);
            //$firstDeal = $deals->first();
            $firstDeal = $deals->pull($deals->first()->id);
            //dump($deals);
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.vote');
    }
}
