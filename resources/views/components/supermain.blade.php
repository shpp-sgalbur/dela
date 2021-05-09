<x-main>
    
    
    <x-desktop :mode="$mode" :active="$active" :currentcategory="$currentcategory" >
       
        {{$active}}
        {{$slot}}
        {{$mode}}
        
    </x-desktop>
</x-main>

