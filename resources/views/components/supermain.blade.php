<x-main>
    
    <x-desktop :active="$active" :category="$currentcategory" :currentcategory="$currentcategory" :mode="$mode">
            
          
        {{$slot}}
        
    </x-desktop>
  
    
    
   
       
        
</x-main>