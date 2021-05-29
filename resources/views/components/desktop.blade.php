<div class="border-solid border-4 border-light-blue-500">
   
    <div class="p-6">
        
        
         
        
        <x-top-menu :currentcategory="$currentcategory" :category="$currentcategory" :active="$active" ></x-top-menu>
        
        <div class="flex flex-row justify-items-end">
            
            <x-categories :currentcategory="$currentcategory"   class="m-10 p-10"></x-categories>
            
            @if($mode==='Home' || $mode==='ShowCategory')     
            
                <x-deals :category="$currentcategory">
                    
                </x-deals>
            @endif
            @if($mode==='CreateCategory')               
                <x-form-create-category ></x-form-create-category>
            @endif
            @if($mode==='EditCategory')   
            <x-form-edit-category :currentcategory="$currentcategory" :mode="$mode"> </x-form-edit-category>
                
            @endif
            @if($mode==='createDeal')            
                <x-creat-deal-form :currentcategory="$currentcategory">
   
                </x-creat-deal-form>
            @endif
            @if($mode=='Vote')            
            <x-vote-form></x-vote-form>
            @endif
            @if($mode='')            
                
            @endif
            @if($mode='')            
                
            @endif
            
            
            
            
        </div>
        
        
    </div>
</div>