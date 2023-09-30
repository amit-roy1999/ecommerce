<?php

use App\Enum\ModulesAccessesEnum;

$now = now();
$pasword = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';

return [

    //AdminSeeder data
    'admins' => [
        [
            'id' => 1,
            'name' => 'Super Admin / Developer',
            'email' => 'superadmin@laravel.com',
            'password' => $pasword,
            'created_at' => $now,
            'updated_at' => $now,
        ],
    ],

    //roleSeeder data
    'roles' => [
        [
            'id' => 1,
            'name' => 'super-admin-dev',
            'created_at' => $now,
            'updated_at' => $now,
        ]
    ],

    //permissionSeeder
    'permissions' => [
        [
            'id' => 1,
            'name' => 'super-admin-dev',
            'route_name' => '*',
            'created_at' => $now,
            'updated_at' => $now,
        ]
    ],

    //adminRoleSeeder
    'adminRole' => [[
        'role_id'  => 1,
        'admin_id'  => 1,
    ]],

    //permissionRoleSeeder
    'permissionRole' => [[
        'role_id'  => 1,
        'permission_id'  => 1,
        'accesses' => json_encode(ModulesAccessesEnum::All, true)
    ]],

];
