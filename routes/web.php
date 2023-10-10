<?php

use App\Livewire\DashbordHome;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', 'admin/login');

Route::get('test', function() {
   dd(App\Models\User::whereId(7)->delete());
//    dd(App\Models\Role::with('permissions')->get()->toArray()[0]['permissions'][0]['pivot']['accesses']);
});

