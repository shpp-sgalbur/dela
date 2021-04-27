<div>
    <label>
        <input wire:model="name" type="text">
    </label>
    hello {{$name}}: {{now()}}
    <button wire:click = "$refresh">refresh</button>
    
</div>
