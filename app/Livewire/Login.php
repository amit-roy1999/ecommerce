<?php

namespace App\Livewire;

use Livewire\Component;

class Login extends Component
{
    public $formFildes;
    public $email;
    public $password;

    public function mount() {
        $this->formFildes = config('forms.adminLogin.fildes');
        // $this->validate(config('forms.adminLogin.validation'));
    }

    public function render()
    {
        return view('livewire.login');
    }
}
