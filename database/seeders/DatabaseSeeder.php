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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // $this->call(AdminSeeder::class);
        // $this->call(RoleSeeder::class);
        // $this->call(PermissionSeeder::class);
        // $this->call(PermissionRoleSeeder::class);
        // $this->call(AdminRoleSeeder::class);

        $this->call(
            [
                RoleSeeder::class,
                AdminSeeder::class,
                PermissionSeeder::class,
                PermissionRoleSeeder::class,
            ]
        );
    }
}
