<div>
    <div class="p-6">
        
        <x-top-menu :currentcategory="$currentcategory" :active="$active" ></x-top-menu>
        <div class="flex flex-row justify-items-end">
            desktop
            {{$currentcategory}}
            tmpl
            <x-categories :currentcategory="$currentcategory"   class="m-10 p-10"></x-categories>
            
            {{$slot}}
            
        </div>
        
        
    </div>
</div>