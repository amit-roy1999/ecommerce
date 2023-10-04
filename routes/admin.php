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
        Route::get('/role-crud', RoleCRUD::class)->name('roleCrud');
        Route::get('/permission-crud', PermissionCRUD::class)->name('permissionCrud');
        Route::get('/users', Users::class)->name('users');
        Route::get('/admins', Admins::class)->name('admins');
    });
});
