<?php

namespace App\Livewire;

use Livewire\Component;

class RadioSelect extends Component
{
    public function render()
    {
        return view('livewire.radio-select');
    }

    public $status = 'new';
}
