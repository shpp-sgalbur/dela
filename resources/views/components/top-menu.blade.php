<div id="menu"class="flex items-center bg-green-500 " >
   
        @foreach($menu as $item=>$url)
            
            <div class="p-2" ><a href="{{route($url,['category'=>$currentcategory])}}" class=" {{$active==$item?$activeStyle:''}}">{{$item}}</a></div>
        @endforeach 
   
   
</div>
