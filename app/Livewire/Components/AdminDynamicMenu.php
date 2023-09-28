<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\Permission;


class AdminDynamicMenu extends Component
{

    public function logout()
    {
        // dd('dd');
        auth()->guard('admin')->logout();
        return $this->redirect(route('admin.login'), true);
    }

    public function render()
    {
        return view(
            'livewire.components.admin-dynamic-menu',
            ['menu' => Permission::whereNotIn('route_name', config('appConfig.hiddenRouteNamesForAdminMenu'))->get(['name', 'route_name'])]
        );
    }
}
