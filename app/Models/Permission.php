<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as BasePermission;

class Permission extends BasePermission
{
    protected static function booted()
    {
        static::creating(function ($role) {
            $role->guard_name = 'web';
        });
    }
}
