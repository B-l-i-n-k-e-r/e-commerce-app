<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TestComponent extends Component
{
    public $message = "Hello Livewire!";

    public function render()
    {
        return view('livewire.test-component');
    }
}