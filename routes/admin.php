<?php

use App\Livewire\DashbordHome;
use App\Livewire\Login;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'admin', 'as' => 'admin.'], function(){

    Route::group(['middleware' => 'adminGuest'], function(){
        Route::get('login', Login::class)->name('login');
    });

    Route::group(['middleware' => 'adminAuth'], function(){
        Route::get('/dashbord', DashbordHome::class)->name('dashbord');
    });
});



