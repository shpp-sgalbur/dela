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
    public function index($currentcategory=null, $mode='ShowCategory')
    {
        echo 'CategoryController '.$currentcategory.'php';
        $categories = Category::where('owner_id',Auth::id());
        
        
        if($categories){
            if(($currentcategory==null))  $currentcategory=$categories->first();
            
            return view('home',['categories' => $categories->paginate(3), 
                                'currentcategory'=>$currentcategory, 
                                'category'=>$currentcategory,
                                'active'=>'Главная', 
                                'mode'=>$mode
                                ]);
        }else{
            return view('no_categories');
        }
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
               'currentcategory'=>$category]);
           
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
        $category = Category::find($id)[0];
        //echo 'CategoryController.Show '.$category;
        //dd($category);
        return view('ShowCategory',
                [
                    'currentcategory'=>$category,
                    'active'=>"", 
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
        $category = Category::find($id)[0];
        return view('editCategory',['currentcategory'=>$category,'active'=> 'Переименовать категорию','mode'=>'EditCategory']);
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
        $category = Category::find($id)[0];
        $category->category = $request->input('category');
        $category->save();
        return view('showCategory',['active'=>'Главная','mode'=>'ShowCategory',
               'currentcategory'=>$category]);
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
    public function voteCreate($id) {
        
    }
}
