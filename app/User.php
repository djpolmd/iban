<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nume', 'prenume', 'locality', 'email', 'password', 'api_token',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','api_token'
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function locality()
    {
       return $this->belongsTo('App\Locality');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function RolesUsers()
    {
      return $this->belongsTo('App\RoleUsers');
    }
    /**
     *  getUserRole = admin | operator |  @return mixed
     */
    public function getUserRole()
    {
        $user = RoleUsers::where('user_id',$this->id)->get('role_id');

        if ($user)
            return
                Roles::where('id', '=', $user->pluck('role_id'))
                           ->get('role_name')
                           ->pluck('role_name')
                           ->first();
        else
            return null;
    }
    /**
     * getUserRolePermissions  @return mixed
     */
    public function getUserRolePermissions()
    {
        $user = RoleUsers::where('user_id', $this->id)->get('role_id');
        return  Roles::where('id', $user->pluck('role_id'))
                        ->get('role_permissions')
                        ->pluck('role_permissions')
                        ->first();
    }
    /**
     * @param $value
     *   User Model @return mixed
     */
    public function getUserByToken($value)
    {
        return User::where('api_token', $value)->get();
    }

    /**
     * @param $token
     * @return mixed
     */
    public function getUserId($token){

        $user =  User::first();

        $user = $user->getUserByToken($token);

        return $user->pluck('id')->last();
    }

    /**
     * @return mixed | null
     */
    public function getToken()
    {
     return $this->api_token;
    }
}
