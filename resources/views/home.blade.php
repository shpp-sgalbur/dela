<x-supermain :active="$active" :mode="$mode" :currentcategory="null" >
    @auth
        <x-deals></x-deals>
    @endauth
    
    
</x-supermain>