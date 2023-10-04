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
        $menus = auth()->guard('admin')->user()->role->permissions()->where('route_name', '*')->first() ?
            Permission::whereNotIn('route_name', config('appConfig.hiddenRouteNamesForAdminMenu'))->get(['name', 'route_name']) :
            auth()->guard('admin')->user()->role->permissions()->get(['name', 'route_name']);

        return view(
            'livewire.components.admin-dynamic-menu',
            ['menu' => $menus]
        );
    }
}
