<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'route_name',
    ];

    public function accesses() : BelongsToMany
    {
        return $this->belongsToMany(Access::class, 'access_permission');
    }
}
