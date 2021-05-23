
<x-supermain :active="$active" :mode="$mode" :currentcategory="$currentcategory" >
    
    <div class="m-2 border-solid border-green-500 border-4 rounded-2xl box-border  bg-green-100">
        <div class=" m-2 text-3xl">
            Список дел категории "{{$currentcategory->category}}"
        </div>
        <div>
            Здесь будет список дел
            
            <x-deals :category="$currentcategory">deals list</x-deals>
        </div>
        
    </div>
     
</x-supermain>
        
        
 