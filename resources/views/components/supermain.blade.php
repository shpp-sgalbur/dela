<x-main>
    @auth
      
        <x-desktop 
            :active="$active" 
            :category="$currentcategory" 
            :currentcategory="$currentcategory" 
            :mode="$mode" :msg="$msg"
            > 

            $slot

        </x-desktop>
    @else
         @include('about')
    @endauth
  
    
    
   
       
        
</x-main>