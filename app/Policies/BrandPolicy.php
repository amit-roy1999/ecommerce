<?php

namespace App\Policies;

use App\Enum\ModulesAccessesEnum;
use App\Models\Admin;
use App\Models\Brand;
use App\Models\User;

class BrandPolicy
{
     /**
     * Perform pre-authorization checks.
     */
    public function before(Admin $admin): bool|null
    {
        if ($admin->whereId($admin->id)->whereHas('role.permissions', fn ($q) => $q->where('route_name', '*'))->first()) {
            return true;
        }
        return null;
    }

    public function create(Admin $admin): bool
    {
        return $admin->whereHas('role.permissions', function ($q) {
            $q->where('table_name', 'brands')->whereJsonContains('accesses', ModulesAccessesEnum::Create->value);
        })->first() ? true : false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin, Brand $brand): bool
    {
        return $admin->whereHas(
            'role.permissions',
            function ($q) {
                $q->where('table_name', 'brands')->whereJsonContains('accesses', ModulesAccessesEnum::Update->value);
            }
        )->first() ? true : false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin, Brand $brand): bool
    {
        return $admin->whereHas(
            'role.permissions',
            function ($q) {
                $q->where('table_name', 'brands')->whereJsonContains('accesses', ModulesAccessesEnum::Delete->value);
            }
        )->first() ? true : false;
    }
}
