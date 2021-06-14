<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class Desktop extends Component
{
    public $mode;
    public $currentcategory;
    public $active ;
    public $slot;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct( $active ='Главная',$mode = "Home", $currentcategory=null)
    {
        
        $this->active=$active;
        $this->mode=$mode;
//        switch ($mode){
//            case 'ShowCategory':
//                $this->active="Главная";
//                break;
//            case 'EditCategory':
//                $this->active="Переименовать категорию";
//                break;
//            case 'Home':
//                $this->active="Главная";
//                $this->currentcategory = Category::where('owner_id',Auth::id())->first();
//                $this->mode=$mode;
//                
//                break;
//            case 'CreateCategory';
//                $this->mode=$mode;
//                $this->active="Добавить категорию";
//                break;
//            case 'createDeal':
//                $this->active="Добавить дело";
//                break;
//            
//                
//        }
           
            
        if($currentcategory){
            
            $this->currentcategory = $currentcategory ;
        }    
        else{
            $this->currentcategory = Category::where('owner_id',Auth::id())->first();
        }
       // echo 'desktop'.$this->currentcategory.'php';
        
       
        
        
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
