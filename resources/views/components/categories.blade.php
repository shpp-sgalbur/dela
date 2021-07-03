
<div class="m-2 border-solid border-green-500 border-2  box-border">
    <div class="flex flex-row ">
        <h6 class=" m-2 p-2 text-2xl bg-green-200">Список категорий</h6>
        <form action="{{route('category.create')}}" class=" m-2">
            <input type="submit" value="+" class="border-2 border-green-500 border-solid m-1 p-1 rounded-lg bg-green-200 h-8 w-8 font-bold text-green-900"/>
        </form>
    </div>
    <hr>
    
    
    @foreach($categories as $category)
    <div class=" m-2">
        
        <div class="{{$currentcategory->id==$category->id?'bg-green-300':''}}">
            <x-category :category="$category"></x-category>
        </div>
       
    </div>
    @endforeach
    
    <!-- Happiness is not something readymade. It comes from your own actions. - Dalai Lama -->
    {{ $categories->setPageName('categoryPage')}}
   
    
    
</div>