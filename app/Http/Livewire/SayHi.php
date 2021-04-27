<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SayHi extends Component
{
    public $name;
    protected $listeners=['refreshChildren'=>'refreshMe'];
    
    public function refreshMe() {
        //$this->emit($refresh);
    }


    public function mount($name)
    {
        $this->name = $name;
    }
    public function render()
    {
        return view('livewire.say-hi');
    }
}
