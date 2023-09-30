<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PermissionRole extends Pivot
{
    //

    // protected function accesses(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn (string $value) => dd($value),
    //     );
    // }

    // protected $casts = [
    //     'accesses' => 'array',
    // ];
}
