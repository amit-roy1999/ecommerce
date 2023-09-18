<?php

namespace App\View\Components;

use App\Models\Permission;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AdminDynamicMenu extends Component
{
    public $menu;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->menu = Permission::whereNotIn('route_name', config('appConfig.hiddenRouteNamesForAdminMenu'))->get(['name', 'route_name']);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin-dynamic-menu');
    }
}
