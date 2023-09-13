<?php

use App\Livewire\DashbordHome;
use App\Livewire\Login;
use Illuminate\Support\Facades\Route;






Route::get('login', Login::class);

Route::get('/dashbord', DashbordHome::class);
