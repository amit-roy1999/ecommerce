<?php

namespace App\Policies;

use App\Enum\ModulesAccessesEnum;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
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
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin, User $model): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin): bool
    {
        return $admin->whereHas('role.permissions', function ($q) {
            $q->where('table_name', 'users')->whereJsonContains('accesses', ModulesAccessesEnum::Create->value);
        })->first() ? true : false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin, User $model): bool
    {
        return $admin->whereHas(
            'role.permissions',
            function ($q) {
                $q->where('table_name', 'users')->whereJsonContains('accesses', ModulesAccessesEnum::Update->value);
            }
        )->first() ? true : false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin, User $model): bool
    {
        return $admin->whereHas(
            'role.permissions',
            function ($q) {
                $q->where('table_name', 'users')->whereJsonContains('accesses', ModulesAccessesEnum::Delete->value);
            }
        )->first() ? true : false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, User $model): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, User $model): bool
    {
        //
    }
}
