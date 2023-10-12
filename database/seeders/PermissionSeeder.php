<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Route;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        Permission::insert(config('seederData.permissions'));
        $allAdminRoutes = [];
        $exceptRoutes = config('appConfig.hiddenRouteNamesForAdminMenu');
        foreach (collect(Route::getRoutes())->toArray() as $value) {
            if (isset($value->action['as']) && !in_array($value->action['as'], $exceptRoutes)&& str_contains($value->action['as'], 'admin.')) {
                $allAdminRoutes[] = [
                    'name' => str_replace('admin.', '', $value->action['as']),
                    'route_name' => $value->action['as'],
                    'table_name' => str_replace('admin.', '',$value->action['as']),
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        // dd($allAdminRoutes);
        Permission::insert($allAdminRoutes);

    }
}
