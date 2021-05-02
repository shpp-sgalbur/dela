<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TopMenu extends Component
{
    public $menu=[
    'Главная'=>'home',
    'Расставить приоритеты'=>'home',
    'Добавить категорию'=>'category.create',
    'Редактировать категорию'=>'home',
    'Добавить дело'=>'home',
    'Найти'=>'home',
    'О сайте'=>'home' 
    ];
    public $active;
    public $activeStyle = 'font-extrabold';

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($active='Главная')
    {
        $this->active=$active;
    }
    
    public function setActive($param) {
        $this->active = $param;
    }
    public function getActive() {
        return $this->active;
    }

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
