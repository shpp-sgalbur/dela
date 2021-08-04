<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class Categories extends Component
{
    public $categories;
    public $currentcategory;
    public $categoryPage;
    //public $categorypaginator;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($currentcategory=null, Request $request)
    {
        
        $allcategories=Category::where('owner_id',Auth::id());
        //$this->categories= Category::all();
        
        if($this->wasClickPaginator($request)){
            $this->categoryPage = $request->categoryPage;
            dump($this->categoryPage);
        }else{
            $this->categoryPage = session('categoryPage');
        }
        
        $this->categories=$allcategories->paginate(3,['*'],'categoryPage',$this->categoryPage)->withQueryString();
        
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
        return view('components.categories');
    }
    private function wasClickPaginator(Request $request){
       
        return strstr($request->fullUrl(), 'categoryPage');
    }
    private function getCategoryPage(Request $request) {
        
    }
}
