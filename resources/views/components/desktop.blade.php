<link rel="stylesheet" href="{{ asset('css/app.css') }}">  
<div>
    <div class="p-6">
        <x-top-menu :active="$active"></x-top-menu>
        {{$slot}}
        
    </div>
</div>