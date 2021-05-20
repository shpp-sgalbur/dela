<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Desktop extends Component
{
    public $mode;
    public $currentcategory;
    public $active ;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct( $active ='Главная',$mode = "Home", $currentcategory=null)
    {
        
        
        switch ($mode){
            case 'ShowCategory':
                $this->active="";
                break;
            case 'EditCategory':
                $this->active="Переименовать категорию";
                break;
            case 'Home':
                $this->active="Главная";
                break;
            case 'CreateCategory';
                
                $this->active="Добавить категорию";
                break;
            case 'createDeal':
                $this->active="Добавить дело";
        }
           
            
            
        $this->currentcategory = $currentcategory ;
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
