<div class="m-2 border-solid border-green-500 border-4 rounded-2xl box-border h-auto">
    
        
            <h6 class=" m-2 text-3xl">Форма редактирования дела в категории <b>{{$currentcategory->category}}</b></h6>
            
            <form action="{{route('deal.update',['deal'=>$deal])}}" method="post" class=" m-2 p-2   ">
                @csrf
                @method('PUT')
                <textarea rows="5" cols="45" name="deal" value="{{$deal->content}}">{{$deal->content}}</textarea>
                <input type="submit" name="btn_category" value="Сохранить" class ="cursor-pointer border-2 border-green-500 border-solid ml-3 p-1 rounded-lg bg-green-200 h-10">
            </form>
            </div>
