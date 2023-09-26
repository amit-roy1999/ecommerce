<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Permission;


class AdminDynamicMenu extends Component
{

    public function logout(){
        
    }

    public function render()
    {
        return view(
            'livewire.admin-dynamic-menu',
            ['menu' => Permission::whereNotIn('route_name', config('appConfig.hiddenRouteNamesForAdminMenu'))->get(['name', 'route_name'])]
        );
    }
}
