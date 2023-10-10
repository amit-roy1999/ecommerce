<?php

use App\Livewire\{
    Admins,
    Users,
    DashbordHome,
    Login,
    PermissionCRUD,
    RoleCRUD,
};

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

    Route::group(['middleware' => 'adminGuest'], function () {
        Route::get('login', Login::class)->name('login');
    });

    Route::group(['middleware' => ['adminAuth', 'adminAccess'] ], function () {
        Route::get('/dashbord', DashbordHome::class)->name('dashbord');
        Route::get('/roles', RoleCRUD::class)->name('roles');
        Route::get('/permissions', PermissionCRUD::class)->name('permissions');
        Route::get('/users', Users::class)->name('users');
        Route::get('/admins', Admins::class)->name('admins');
    });
});
