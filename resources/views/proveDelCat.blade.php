<x-main>
<div class="m-2 p-2 border-solid border-green-500 border-4 rounded-2xl box-border">
<div>Вы уверены, что хотите удалить категорию <b>{{$category->category}}</b> со всем ее содержимым?</div>
<div>Возможно вы захотите перенести дела в другую категорию.</div><br>
<div class="flex justify-between ">
    <form >
        <button formaction="{{route('category.show',['category'=>$category])}}" class ="cursor-pointer border-2 border-green-500 border-solid  p-1 rounded-lg bg-green-300">
             Отменить удаление категории
        </button>

    </form>

    <form method="POST">
        @method('DELETE')
        @csrf
        
        <button formaction="{{route('category.destroy',['category'=>$category])}}" class ="cursor-pointer border-2 border-green-500 border-solid  p-1 rounded-lg bg-red-300">
             Удалить категорию
        </button>
    </form>
</div>
</div>
</x-main>