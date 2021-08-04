<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
    public function index($currentcategory=null, $mode='ShowCategory', $msg=null)
    {
        
        //echo 'CategoryController:index '.$currentcategory.'php';
        $categories = Category::where('owner_id',Auth::id());
        
        
        if($categories){
            if(($currentcategory==null))  $currentcategory=$categories->first();
    
            return view('components.supermain',['categories' => $categories->paginate(3), 
                                'currentcategory'=>$currentcategory, 
                                'category'=>$currentcategory,
                                'active'=>'Главная', 
                                'mode'=>$mode,
                                'msg'=>$msg
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
        return view('components.supermain',['user_id'=>Auth::id(),'active'=>'Добавить категорию','mode'=>'CreateCategory', 'currentcategory'=>null, 'msg'=>null]);
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
                        return "double";
                        break;
                    }
                }
                
            }
            
            $category = new Category;
            $category->owner_id=$owner_id;
            $category->category=$category_name;
            $category->deals = '';
            $category->save();
            
            $categories_arr[] = $category->id;
            $user->categories = implode(';', $categories_arr);
            $user->save();
            
            
            


                //$msg = "Категория ".'"'.$request->input('category').'"'." успешно создана ";
                return $category;
        });
       if($category && $category!=='double'){
           
           $request->session()->flash('category',$category->category);
           session(['category'=>$category->category]);
           
            $msg = "Категория ". $request->input('category')."  успешно создана ";
            
           // return view('components.supermain',['active'=>'Добавить категорию','mode'=>'StoreCategory','currentcategory'=>$category, 'msg'=>$msg]);
           
       }
       else{
           $request->session()->flash('category',$request->category);
           if($category==='double'){
                $msg = "Категория $request->category уже существует";
                $category= Category::firstWhere('category',$request->category);
           }
           else{
               $msg = "Что то пошло не так";
           }
       }
       session(['msg'=>$msg]);
        return redirect()->route('category.show',['category'=>$category,'msg'=>$msg]);
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( Request $request, $category=null, $msg=null)
    {
        
        //dump($request->session()->get('attributes'));
        //if(!isset($countvote)) $countvote=[];
        //$countvote = $request->session()->get("countvote[$category->id]");
        if($request->session()->has("countvote")){
            $arr = $request->session()->get("countvote");
            //dd($arr);
            if(!array_key_exists($category->id,$arr)){
                //dd($arr);
                $request->session()->forget("countvote");
                $request->session()->push("countvote.$category->id", 3);
                
            }
        
           //dump (array_keys($arr,$category->id));
            //
                echo '$request->session()->forget(name);';
          // dump($countvote) ;
           //dump($request->session()->get("countvote"));
           //dump($request->session()->all());
        }else{
            $request->session()->push("countvote.[$category->id]", 3);
        }
        
        //$request->session()->put("countvote[$category->id]", 0);
        //dump($request->session()->all());
        //$category = $id;
        //echo 'CategoryController.Show '.$category;
        //dd($category);
        $msg=$request->msg?$request->msg:null;
        $request->session()->put('category', $category->category);
        $request->session()->flash('category', $category->category);
        session(['category'=> $category->category]);
        return redirect()->route('deal.index',['category'=>$category->id, 'msg'=>$msg]);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        return view('components.supermain',['currentcategory'=>$id,'active'=> 'Переименовать категорию','mode'=>'EditCategory', 'msg'=>null]);
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
        
        $category = $id;
        
        $category->category = $request->input('category');
        $category->save();
        return view('components.supermain',['active'=>'Главная','mode'=>'ShowCategory',
               'currentcategory'=>$category, 'msg'=>null]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $category)
    {
        $request->session()->reflash('category',$category->category);
        session(['category'=>$category->category]);
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
            $msg = "Категория $category->category была удалена";
            
            return redirect()->route('category.index',['msg'=>$msg]);
        }
        else{
            $msg = "Что-то пошло не так. Категорию $category удалить не удалось";
             return view('components.supermain',['active'=>'Главная','mode'=>'ShowCategory',
               'currentcategory'=>$category, 'msg'=>$msg]);
        }
       
    }
    
}
