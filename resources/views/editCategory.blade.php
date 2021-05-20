
<x-supermain :active="$active" :mode="$mode" :currentcategory="$currentcategory">
    <div>
    Здесь будет редактироваться категория {{$currentcategory->category}}
    <x-form-edit-category  :currentcategory="$currentcategory"></x-form-edit-category>
</div>
</x-supermain>