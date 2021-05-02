<div>
    <p>{{$category}}</p>
    <!-- Well begun is half done. - Aristotle -->
    @if(sizeof($deals)==0)
        <div>
            Список дел в категории пуст. Чтобы добавить дело выберите "Добавить дело"
        </div>
    @else
        $foreach($deals as $deal)
            <div>
                <x-deal :deal="$deal">

                </x-deal>

            </div>
        @endforeach
    @endif
</div>