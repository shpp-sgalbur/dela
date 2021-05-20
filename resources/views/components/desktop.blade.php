<div>
    <div class="p-6">
        
        
        
        
        <x-top-menu :currentcategory="$currentcategory" :category="$currentcategory" :active="$active" ></x-top-menu>
        
        <div class="flex flex-row justify-items-end">
            
            <x-categories :currentcategory="$currentcategory"   class="m-10 p-10"></x-categories>
            
            {{$slot}}
            
        </div>
        
        
    </div>
</div>