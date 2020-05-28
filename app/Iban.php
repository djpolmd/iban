<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Iban extends Model
{
    use Notifiable;

    protected  $fillable = [
        'cod_eco',
        'cod_local',
        'cod_raion',
        'iban',
];



}