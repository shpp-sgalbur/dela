
     
    @if($deals->total()==null)
        <div>
            Список дел в категории пуст. Чтобы добавить дело выберите "Добавить дело"
        </div>
    @else
        <div class="m-2 border-solid border-green-500 border-4 rounded-2xl box-border  bg-green-100">
                        <div class=" m-2 text-3xl">
                            Список дел категории "{{$category->category}}"
                        </div>
                                
                  
        @foreach($deals as $deal)
            <x-deal-comp :deal="$deal" :category="$category"></x-deal-comp>            
        @endforeach
        
        {{$deals->setPageName('dealPage')}}
        
        
         </div>
   
    @endif
