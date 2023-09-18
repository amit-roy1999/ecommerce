<?php

namespace Database\Seeders;

use App\Models\AccessPermission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccessPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AccessPermission::insert(config('seederData.accessPermission'));
    }
}
