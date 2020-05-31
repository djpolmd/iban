<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EcoCod extends Model
{
    protected $fillable = [
        'cod',
        'name'
    ];

    /**
     * @return false|string
     */
//    public function getJson()
//    {
//        return json_encode(($this->cod . ' - ' .  $this->name),JSON_FORCE_OBJECT);
//    }

    /**
     * @return false|string
     */
    public function getEcoCod()
    {
        return "'" . $this->cod . ' - ' .  $this->name . "'";
    }

}
