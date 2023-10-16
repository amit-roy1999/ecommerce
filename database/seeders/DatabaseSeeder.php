<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            AdminSeeder::class,
            PermissionSeeder::class,
            PermissionRoleSeeder::class,
        ]);
        \App\Models\Category::factory(10)->parentId(false)->create();
        \App\Models\Category::factory(30)->parentId([1, 10])->create();
        \App\Models\Category::factory(100)->parentId([11, 40])->create();

        \App\Models\User::factory(100)->create();
    }
}
