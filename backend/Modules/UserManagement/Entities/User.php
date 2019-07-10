<?php

namespace Modules\UserManagement\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $table = "users";

    protected $fillable = [
        'email', 'password', 'username'
    ];

    protected $hidden = [
        'password', 'remember_token', 'created_at', 'deleted_at', 'generate_password_token'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'email' =>  $this->email,
            'csrf-token' => str_random(32)
        ];
    }

    public function portalUser()
    {
        return $this->hasOne('\Modules\UserManagement\Entities\PortalUser');
    }

    public function userDetail()
    {
        return $this->hasOne('\Modules\UserManagement\Entities\UserDetail');
    }

    public function donorStatus()
    {
        return $this->hasMany('\Modules\UserManagement\Entities\DonorStatus');
    }
}
