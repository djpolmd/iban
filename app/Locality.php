<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Locality extends Model
{
    protected $fillable =
        [
            'cod1',
            'cod2',
            'cod3',
            'name',
        ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
