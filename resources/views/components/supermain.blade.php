<x-main>
    @auth
      
        <x-desktop :active="$active" :category="$currentcategory" :currentcategory="$currentcategory" :mode="$mode"> 

            $slot

        </x-desktop>
    @else
         @include('about')
    @endauth
  
    
    
   
       
        
</x-main>