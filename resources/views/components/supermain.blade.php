<x-main>
    
    <x-desktop :mode="$mode" >
       
        {{$active}}
        {{$slot}}
        {{$mode}}
        
    </x-desktop>
</x-main>

