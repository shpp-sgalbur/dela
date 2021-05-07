<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('Components.categories',['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('newCategoryForm',['user_id'=>Auth::id(),'active'=>'Добавить категорию','mode'=>'CreateCategory']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $category=DB::transaction(function () use ($request) {
        $category_name = $request->input('category');
        $owner_id=Auth::id();
        $user = User::find(Auth::id());
        
        $categories_arr = explode(';', $user->categories);
        $key = array_search($category_name, $categories_arr);            
        if($key === false){
            $categories_arr[] = $category_name;
            $user->categories = implode(';', $categories_arr);
            $user->save();
        }
        else{
            
            echo "Категория ".'"'.$category_name.'"'." уже существует ";
            return false;
        }
        $category = new Category;
            $category->owner_id=$owner_id;
            $category->category=$category_name;
            $category->save();

            
            echo  "Категория ".'"'.$request->input('category').'"'." успешно создана ";
            return $category;
        });
       if($category){
           return view('showCategory',['active'=>'Добавить категорию','mode'=>'StorCategory',
               'category'=>$category]);
           
       }
       else{
          return view('home',['active'=>'Главная']);
       }
        
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        //dd($category->id);
        return view('showCategory',
                [
                    'current_category'=>$category,
                    'active'=>"Главная", 
                    'mode'=>'ShowCategory',  
                ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('editCategory',['category'=>$category,'active'=> 'Переименовать категорию','mode'=>'EditCategory']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
       
    }
}
