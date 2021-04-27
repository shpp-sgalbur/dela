<div>

    

        
    @foreach($contacts as $contact)
        <div v-for="item in items":key="item.id"></div>
        @livewire('say-hi',['name'=>$contact],key($contact))
        
        <br>
        
    @endforeach
    <hr><hr>
    {{now()}}
    <button wire:click = "refreshChildren">refresh Children</button>
    
    
    </div>

