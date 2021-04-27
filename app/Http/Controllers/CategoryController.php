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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('newCategoryForm',['user_id'=>Auth::id(),'active'=>'Добавить категорию']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $res=DB::transaction(function () use ($request) {
        $category = $request->input('category');
        $owner_id=Auth::id();
        $user = User::find(Auth::id());
        
        $categories_arr = explode(';', $user->categories);
        $key = array_search($category, $categories_arr);            
        if($key === false){
            $categories_arr[] = $category;
            $user->categories = implode(';', $categories_arr);
            $user->save();
        }
        else{
            
            echo "Категория ".'"'.$category.'"'." уже существует ";
            return false;
        }
        Category::create([
            'owner_id'=>$owner_id,
            'category'=>$category

            ]);
            echo  "Категория ".'"'.$request->input('category').'"'." успешно создана ";
            return true;
        });
       if($res){
           return view('newCategoryForm',['active'=>'Добавить категорию']);
           
       }
       else{
          return view('welcome',['active'=>'Главная']);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
