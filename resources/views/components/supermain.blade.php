<x-main>
    @auth
      
        <x-desktop :active="$active" :category="$currentcategory" :currentcategory="$currentcategory" :mode="$mode"> 

            

        </x-desktop>
    @else
         @include('about')
    @endauth
  
    
    
   
       
        
</x-main>