<x-desktop >
    <div>
        <h1>Форма создания новой категории user {{$user_id}}</h1>

    <form action="{{route('category.store')}}" method="post">
        @csrf
        <input type="text" name="category" placeholder="название категории">
        <input type="submit" name="btn_category" value="Создать">
    </form>
    </div>
</x-desktop>