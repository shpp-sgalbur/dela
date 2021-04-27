<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;

class HelloWorld extends Component
{
    public $contacts=[];
    public $triggerValue = '';
    
    public function mount($contacts)
    {
        $this->contacts = $contacts;
        
//        foreach ($this->contacts  as $contact){
//            $this->contacts['name'] = $contact;
//        }
        
    }
   
    public function render()
    {
        return view('livewire.hello-world',['contacts'=> $this->contacts]);
    }
    public function removeContact($contact) {
        $key = array_search($contact, $this->contacts);
        unset($this->contacts[$key]);
        $refresh;
    }
    public function refreshChildren() {
        $this->emit('refreshChildren');
    }
     
    
}
