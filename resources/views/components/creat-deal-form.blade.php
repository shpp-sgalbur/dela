
    <div class="m-2 border-solid border-green-500 border-4 rounded-2xl box-border h-auto">
     
    <h6 class=" m-2 text-3xl">Форма создания нового дела</h6>
    <form action="{{route('storeDeal',['category'=>$currentcategory])}}" method="post" class=" m-2 p-2   ">
        @csrf
        <textarea cols="50" rows="10" name="deal" placeholder="введите описание дела"></textarea>
        <input type="submit" name="btn_category" value="Создать" class ="cursor-pointer border-2 border-green-500 border-solid ml-3 p-1 rounded-lg bg-green-200 h-10">
    </form>
    </div>
