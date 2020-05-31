<?php

namespace App;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;

class RoleUsers extends Model
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
   public function Roles()
   {
        return $this->HasOne('App\Roles', 'role_id');
   }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function User()
    {
        return $this->HasOne('App\User', 'user_id');
    }

    public function getRoleId()
    {
        return $this->role_id;
    }

    public function setRoleId($value)
    {
        $this->role_id = $value;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

}
