<?php

// use App\Livewire\{
//     Admins,
//     AdminWelcomePage,
//     Categories,
//     Users,
//     DashbordHome,
//     Login,
//     PermissionCRUD,
//     RoleCRUD,
// };

use App\Livewire\Brands;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'App\Livewire','prefix' => 'admin', 'as' => 'admin.'], function () {

    Route::group(['middleware' => 'adminGuest'], function () {
        Route::get('login', Login::class)->name('login');
    });

    Route::group(['middleware' => ['adminAuth', 'adminAccess'] ], function () {
        Route::get('/dashbord', DashbordHome::class)->name('dashbord');
        Route::get('/roles', RoleCRUD::class)->name('roles');
        Route::get('/permissions', PermissionCRUD::class)->name('permissions');
        Route::get('/admins', Admins::class)->name('admins');

        Route::get('/users', Users::class)->name('users');
        Route::get('/categories', Categories::class)->name('categories');
        Route::get('/brands', Brands::class)->name('brands');
    });
});

Route::get('/admin/welcome', App\Livewire\AdminWelcomePage::class)->name('adminWelcome');
