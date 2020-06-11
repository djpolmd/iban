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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }


    /**
     * @param $value
     * @return string
     */
    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    /**
     * @return mixed
     */
    public function isRaion()
    {
        if (($this->cod1 === $this->cod2) and ($this->cod2 === $this->cod3))
         {
             return true;
         }
    }

    /**
     * @return string
     */
    public function getRaion()
        {
            if($this->isRaion())
              {
                  return "'" .$this->cod3 . ' - ' . $this->name . "'";
              }
        }

    /**
     * @return string
     */
    public function getSector()
        {
            if(!$this->isRaion())
                {
                    return "'" .$this->cod3 . ' - ' . $this->name . "'";
                }
        }

    /**
     * @return mixed
     */
    public function getCodRaion()
    {
     return $this->cod1;
    }

    /**
     * @return mixed
     */
    public function getIbanRaion()
    {
        return
             Iban::where('cod_local','=', $this->cod1)
                 ->pluck('cod_raion')
                 ->first();
    }
}
