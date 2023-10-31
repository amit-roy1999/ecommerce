<?php

namespace App\Policies;

use App\Enum\ModulesAccessesEnum;
use App\Models\Admin;
use App\Models\Product;
use App\Models\User;

class ProductPolicy
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
    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin): bool
    {
        return $admin->whereHas('role.permissions', function ($q) {
            $q->where('table_name', 'products')->whereJsonContains('accesses', ModulesAccessesEnum::Create->value);
        })->first() ? true : false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin, Product $product): bool
    {
        return $admin->whereHas(
            'role.permissions',
            function ($q) {
                $q->where('table_name', 'products')->whereJsonContains('accesses', ModulesAccessesEnum::Update->value);
            }
        )->first() ? true : false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin, Product $product): bool
    {
        return $admin->whereHas(
            'role.permissions',
            function ($q) {
                $q->where('table_name', 'products')->whereJsonContains('accesses', ModulesAccessesEnum::Delete->value);
            }
        )->first() ? true : false;
    }
}
