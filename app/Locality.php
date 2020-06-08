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

    public function getCode3Attribute($value)
    {
        return ucfirst($value);
    }

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
//         Locality::all()
//             ->where('cod3', '=', $this->cod1)
//             ->pluck('cod3')
//             ->last();
    }
}
