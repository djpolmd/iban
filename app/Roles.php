<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $fillable = [
        'role_name',
        'role_enabled',
        'role_permissions',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datatime',
    ];
}
