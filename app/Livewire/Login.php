<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $loginForm;
    public $email;
    public $password;
    public $rememberMe;

    public function mount()
    {
        $this->loginForm = config('forms.adminLogin');
    }

    public function login()
    {
        // dd($this);
        $this->validate(config('forms.adminLogin.validation'));
        if (Auth::guard('admin')->attempt(['email' => $this->email, 'password' => $this->password], $this->rememberMe)) {
            return redirect()->route('admin.dashbord');
        }
    }

    public function render()
    {
        return view('livewire.login');
    }
}
