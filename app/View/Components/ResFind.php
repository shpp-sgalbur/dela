<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use App\Models\User;
use App\Models\Deal;
use App\Models\Category;
use Illuminate\Http\Request;


class ResFind extends Component
{
    public $dealsList=null;
    public $msg=null;
    public $allCategories=false;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($category, Request $request)
    {
        $msg='';
        if($request->input('word')[1] =="" and $request->input('word')[2] == ""){
            $msg = "Ни одно поле не заполнено";
            $this->msg;
        }else{
            //если надо выполнить поиск в текущей категории
            if(isset($request->input('Submit')[1])){
                $where = "category_id = $category->id";
                $this->allCategories = false;
                
            }
            //если надо выполнить поиск во всех категориях
            if(isset($request->input('Submit')[2])){
                $categoriesStr = User::find(Auth::id())->categories;
                $categoriesStr = str_replace(';',',',$categoriesStr);
                if($categoriesStr[0]==',') $categoriesStr = substr ($categoriesStr, 1);
                $where = "category_id IN ($categoriesStr)";
                $this->allCategories = true;
                
            }
            //если заполнены оба поля
            if($request->input('word')[1] !="" and $request->input('word')[2] != ""){
                //если Должно присутствовать любое из слов
                
                if($request->input('radiobutton') == 1){
                    $msg="(должен присутствовать любой из фрагментов)";
                    $likeString = '(content LIKE ? OR content LIKE ?)';                                        
                }
                else{
                    $msg="(должны присутствовать оба фрагмента)";      
                    $likeString = "(content LIKE ? AND content LIKE ?)";                                      
                }
                $res = Deal::whereRaw($where)->whereRaw($likeString,['%'.$request->input('word')[1].'%','%'.$request->input('word')[2].'%'])->get();  
            }
            else{
                //если заполнено только первое поле
                if($request->input('word')[1] !=""){                        
                    $searchString = $request->input('word')[1];
                }else{
                    //если заполнено только второе поле
                    $searchString = $request->input('word')[2];                                               
                }
                $res = Deal::whereRaw( $where)->whereRaw("content LIKE ?",['%'.$searchString.'%'])->get();
            }
            
        }      
        $this->dealsList=$res;
        
        $count = sizeof($res);
        $this->msg = "Результат поиска $msg:<br>"
                ."<b>".$request->input('word')[1]."</b>"."<br>"
                ."<b>".$request->input('word')[2]."</b>"."<br>"
                . " Обнаружено дел : <b>$count</b>.";
        
    }
    public function getCategoryName($id) {
        
        return $this->getCategory($id)->category;
        
    }
    public function getCategory($id){
        
        return Category::find($id);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.res-find');
    }
}
