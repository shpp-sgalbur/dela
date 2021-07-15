<form name="form_find" method="post" action="{{route('find',['category'=>$category])}}" >
     @csrf
    <div class="m-2 p-2 border-solid border-green-500 border-4 rounded-2xl box-border">
        <h1 class=" m-2 text-3xl">Форма поиска</h1>
        <p>Введите по-одному слову в каждое поле. Желательно слова вводить без окончаний.<br>
  Например, вместо слова "реформа" пишем "реформ".<br>
Все поля заполнять не обязательно.</p>
       
  
        <input type="text" name="word[1]" class="m-2 p-2"><br>
    <input name="word[2]" type="text" class="m-2 p-2"><br>
    
 
  <label>
  <input type="radio" name="radiobutton" value="2">
  Должны присутствовать оба слова</label>
  <label> <br>
  <input type="radio" name="radiobutton" value="1" checked="">
  Должно присутствовать любое из слов</label><br>
  <input type="submit" name="Submit[1]" value="Искать в текущей категории" class ="cursor-pointer border-2 border-green-500 border-solid  p-1 rounded-lg bg-green-300  h-8 "> 
  <input type="submit" name="Submit[2]" value="Искать во всех катеориях" class ="cursor-pointer border-2 border-green-500 border-solid  p-1 rounded-lg bg-green-300  h-8 ">
  </div>
</form>
