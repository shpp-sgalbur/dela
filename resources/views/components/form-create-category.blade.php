
    <div>
        
    {{$slot}}
    <form action="{{route('category.store')}}" method="post">
        @csrf
        <input type="text" name="category" placeholder="название категории">
        <input type="submit" name="btn_category" value="Создать">
    </form>
    </div>
