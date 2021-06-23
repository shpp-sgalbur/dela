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
        //echo 'CategoryController:index '.$currentcategory.'php';
        $categories = Category::where('owner_id',Auth::id());
        
        
        if($categories){
            if(($currentcategory==null))  $currentcategory=$categories->first();
    
            return view('components.supermain',['categories' => $categories->paginate(3), 
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
            echo 'store';
            
            foreach ($categories_arr as $categoty_id){
                
                $cat = Category::find($categoty_id);
                if($cat){
                    
                    if( $category_name == $cat->category){
                        echo "Категория ".'"'.$category_name.'"'." уже существует ";
                        return false;
                        break;
                    }
                }
                
            }
            
            $category = new Category;
            $category->owner_id=$owner_id;
            $category->category=$category_name;
            $category->save();
            
            $categories_arr[] = $category->id;
            $user->categories = implode(';', $categories_arr);
            $user->save();
            
            
            


                echo  "Категория ".'"'.$request->input('category').'"'." успешно создана ";
                return $category;
        });
       if($category){
          
           return view('components.supermain',['active'=>'Добавить категорию','mode'=>'StorCategory',
               'currentcategory'=>$category]);
           
       }
       else{
          return view('home',['active'=>'Главная', 'mode'=>'Home']);
       }
        
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( Request $request, $category=null)
    {
//        echo 'public function show';
//        dd($category);
        //dump($request->session()->get('attributes'));
        //if(!isset($countvote)) $countvote=[];
        //$countvote = $request->session()->get("countvote[$category->id]");
        if($request->session()->has("countvote")){
            $arr = $request->session()->get("countvote");
            dump($arr);
            if(!array_keys($arr,$category->id)){
                $request->session()->forget("countvote");
                $request->session()->push("countvote.$category->id", 3);
            }
            
           dump (array_keys($arr,$category->id));
            //
                echo '$request->session()->forget(name);';
          // dump($countvote) ;
           dump($request->session()->get("countvote"));
           //dump($request->session()->all());
        }else{
            $request->session()->push("countvote.[$category->id]", 3);
        }
        
        //$request->session()->put("countvote[$category->id]", 0);
        //dump($request->session()->all());
        //$category = $id;
        //echo 'CategoryController.Show '.$category;
        //dd($category);
        return view('components.supermain',
                [
                    'currentcategory'=>$category,
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
        $category = Category::find($id)[0];
        return view('components.supermain',['currentcategory'=>$category,'active'=> 'Переименовать категорию','mode'=>'EditCategory']);
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
        return view('components.supermain',['active'=>'Главная','mode'=>'ShowCategory',
               'currentcategory'=>$category]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($category)
    {
        //
        $res=DB::transaction(function () use ($category){
            $user = User::find(Auth::id());
            $categories_arr = explode(';', $user->categories);
            foreach ($categories_arr as $key=>$category_id){
                if($category_id == $category->id){
                    unset($categories_arr[$key]);
                    $user->categories = implode(';', $categories_arr);
                    $user->save();
                    $category->delete();
                    return true;
                    break;
                }
            }
            return false;
        });
        if($res){
            return redirect()->route('category.index');
        }
        else{
             return view('components.supermain',['active'=>'Главная','mode'=>'ShowCategory',
               'currentcategory'=>$category]);
        }
       
    }
    
}
