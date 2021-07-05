<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;

class TopMenu extends Desktop
{
    public $menu=[
        'Главная'=>'category.show',
        'Расставить приоритеты'=>'voteCreate',
        'Добавить категорию'=>'category.create',
        'Переименовать категорию'=>'category.edit',
        'Добавить дело'=>'createDeal',
        'Поиск'=>'find',
        'О сайте'=>'home',
        'Помощь'=>'home',
        'Мнения и пожелания'=>'home'
    ];
    public $active;
    public $activeStyle = 'font-extrabold';
    public $currentcategory;
    //public $category;//категория на которую будет указывать динамически сгенерированная ссылка пункта меню


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
            //$this->menu['Переименовать категорию'] = 'category.edit';
        }else{
            $this->currentcategory= Category::where('owner_id',Auth::id())->first();
            
                        
        }
        if($this->currentcategory == null){
                unset($this->menu['Главная']);
                unset($this->menu['Переименовать категорию']);
                unset($this->menu['Добавить дело']);
                unset($this->menu['Расставить приоритеты']);
            }
        //dd($this->menu);
        
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
