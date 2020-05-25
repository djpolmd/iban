<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RolesUsers extends Model
{
    /**
     * @var array
     */

    protected $fillable = [
        'user_id',
        'role_id',
        'updated_by',
    ];

    /**
     * @var array
     */
   protected $casts = [
    'updated_at' => 'datatime',
    ];
}
