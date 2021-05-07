<div>
    <div class="p-6">
        
        <x-top-menu :active="$active"></x-top-menu>
        <div class="flex flex-row justify-items-end">
            
            <x-categories :current_category="$current_category"   class="m-10 p-10"></x-categories>
            
            {{$slot}}
            
        </div>
        
        
    </div>
</div>