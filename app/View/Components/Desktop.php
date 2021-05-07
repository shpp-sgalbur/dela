<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Desktop extends Component
{
    public $mode;
    public $current_category;
    public $active ;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct( $active ='Главная',$mode = "Home", $current_category=null)
    {
        echo $current_category;
        dd($current_category);
        switch ($mode){
            case 'ShowCategory':
            case 'EditCategory':
                $this->active="Переименовать категорию";
                break;
            case 'Home':
                $this->active="Главная";
                break;
            case 'CreateCategory';
                
                $this->active="Добавить категорию";
                break;
        }
           
            
            
        $this->current_category = $current_category ;
        
       
        
        
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
