<div class="border-solid border-4 border-light-blue-500">
   
    <div class="p-6">
        
        
         
        
        <x-top-menu :currentcategory="$currentcategory"  :active="$active" ></x-top-menu>
        
        <div class="flex flex-row justify-items-end">
            
            <x-categories :currentcategory="$currentcategory"   class="m-10 p-10"></x-categories>
            <div>
                
                <x-msg :msg="$msg" :category="$category"></x-msg>
            
            @if($mode==='Home' || $mode==='ShowCategory')
            
                @if($currentcategory != null)
                
                    <x-deals :category="$currentcategory">
                    
                    </x-deals>
                @endif
            
                
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
            
            <x-vote-form :category="$currentcategory"></x-vote-form>
            @endif
            @if($mode==='EditDeal')  
            
            <x-form-edit-deal ></x-form-edit-deal>
                
               
            @endif
            @if($mode=='StoreCategory')     
            <div class="text-3xl m-2 p-2">
                Категория <i><b class="text-4xl">{{$currentcategory->category}}</b></i> успешно создана
                </div>
                
            @endif
            @if($mode=='Find')            
                find Form will be here!!
            @endif
            </div>
            
            
            
            
            
        </div>
        
        
    </div>
</div>