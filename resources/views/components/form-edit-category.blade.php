 
<div class="m-2 border-solid border-green-500 border-4 rounded-2xl box-border">
        
    <h6 class=" m-2 text-3xl">Форма редактирования категории <br><b>{{$currentcategory->category}}</b> </h6>
    <form action="{{route('category.update',['category'=>$currentcategory])}}" method="post" class=" m-2 p-2   ">
        @csrf
        @method('PUT')
        <input type="text" name="category" value="{{$currentcategory->category}}">
        
        <input type="submit" name="btn_category" value="Переименовать" class ="cursor-pointer border-2 border-green-500 border-solid ml-3 p-1 rounded-lg bg-green-200 h-10">
    </form>
    </div>
