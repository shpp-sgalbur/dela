<div>
    
   
    <!-- Well begun is half done. - Aristotle -->
    @if(($deals)==null)
        <div>
            Список дел в категории пуст. Чтобы добавить дело выберите "Добавить дело"
        </div>
    @else
    
        @foreach($deals as $deal)
            {{$deal}}
        @endforeach
        {{$deals->links()}}
   
    @endif
    
</div>