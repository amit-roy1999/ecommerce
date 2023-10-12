<?php

namespace App\Livewire;

use Livewire\Component;

class AdminWelcomePage extends Component
{
    function mount()
    {
        $permissions = auth()->guard('admin')->user()->role->permissions()->get()->toArray();
        if (count($permissions)) {
            return  $this->redirect(route($permissions[0]['route_name']), true);
        }
    }
    public function render()
    {

        return <<<'HTML'
        <div>
            <h3>Welcome {{ auth()->guard('admin')->user()->name }}, please add permissions for this role to access functions.</h3>
        </div>
        HTML;
    }
}
