<div class="w-auto m-2 border-solid border-4 border-light-blue-500">
     
    @if($deals->total()==null)
        <div>
            Список дел в категории пуст. Чтобы добавить дело выберите "Добавить дело"
        </div>
    @else
    
        @foreach($deals as $deal)
            <x-deal :deal="$deal" :category="$category"></x-deal>            
        @endforeach
        {{$deals->links()}}
   
    @endif
    
</div>