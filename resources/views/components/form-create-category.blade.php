
    <div class="m-2 border-solid border-green-500 border-4 rounded-2xl box-border h-40">
        
    <h6 class=" m-2 text-3xl">Форма создания новой категории</h6>
    <form action="{{route('category.store')}}" method="post" class=" m-2 p-2   ">
        @csrf
        <input type="text" name="category" placeholder="название категории">
        <input type="submit" name="btn_category" value="Создать" class="cursor-pointer m-2">
    </form>
    </div>
