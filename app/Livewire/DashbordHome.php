<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Route;
use Livewire\Component;

class DashbordHome extends Component
{
    public function render()
    {
        // dd(collect(Route::getRoutes())->toArray());

        return view('livewire.dashbord-home');
    }
}
