<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PermissionRole extends Pivot
{
    //

    protected $casts = [
        'accesses' => 'array',
    ];
}
