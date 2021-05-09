
<x-supermain :active="$active" :mode="$mode" :currentcategory="$currentcategory" >
    
    <div class="m-2 border-solid border-green-500 border-4 rounded-2xl box-border h-40">
        <div class=" m-2 text-3xl">
            
        </div>
        <div>
            Здесь будет список дел
            
            <x-deals :category="$currentcategory"></x-deals>
        </div>
        
    </div>
     
</x-supermain>
        
        
 