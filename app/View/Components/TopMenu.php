<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;

class TopMenu extends Desktop
{
    public $menu=[
    'Главная'=>'home',
    'Расставить приоритеты'=>'home',
    'Добавить категорию'=>'category.create',
    //'Редактировать категорию'=>'category.edit',
    'Добавить дело'=>'createDeal',
    'Найти'=>'home',
    'О сайте'=>'home' 
    ];
    public $active;
    public $activeStyle = 'font-extrabold';
    public $currentcategory;
    public $deal_id;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct( $currentcategory=null,$active='Главная')
    {
        $this->active=$active;
        if($currentcategory){
            $this->currentcategory=$currentcategory;
        }else{
            $this->currentcategory= Category::where('owner_id',Auth::id())->first();
        }
        
        //$this->menu['Добавить дело']="categories/".$currentcategory."/createdeal";
        if($active == 'Переименовать категорию'){
            $this->menu['Редактировать категорию'] = 'category.create';
        }
        if($active == 'Переименовать категорию'){
            $this->menu['Переименовать категорию'] = 'category.create';
        }
        
    }
    
//    public function setActive($param) {
//        $this->active = $param;
//    }
//    
//    public function getActive() {
//        return $this->active;
//    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.top-menu');
    }
}
