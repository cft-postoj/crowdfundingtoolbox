<?php

namespace Modules\UserManagement\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\UserManagement\Services\UserSearchService;
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
        $backOfficeUser = BackOfficeUser::where('user_id', $this->id)->first();
        if ($backOfficeUser !== null) {
            $userDetail = UserDetail::where('user_id', $this->id)->first();
            return [
                'email' =>  $this->email,
                'firstName' => ($userDetail !== null) ? $userDetail->first_name : 'BackOffice',
                'lastName' => ($userDetail !== null) ? $userDetail->last_name : 'User',
                'role' => BackOfficeRole::where('id', BackOfficeRole::where('id', $backOfficeUser['role_id'])->first()['id'])->first()['slug']
            ];
        }
        return [
            'email' =>  $this->email
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
