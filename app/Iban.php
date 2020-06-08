<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Iban extends Model
{
    use Notifiable;

    public $timestamps = false;

    protected  $fillable = [
        'cod_eco',
        'cod_local',
        'cod_raion',
        'iban',
];

    /**
     * @return false|string
     */
    public function getLastCharacters()
    {
        return substr($this->iban, 10, 14);
    }

}
