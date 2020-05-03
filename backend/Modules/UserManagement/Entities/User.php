<?php

namespace Modules\UserManagement\Entities;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\UserManagement\Services\UserSearchService;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use Filterable;

    protected $table = "users";

    protected $fillable = [
        'email', 'password', 'username'
    ];

    protected $hidden = [
        'password', 'remember_token', 'created_at', 'deleted_at', 'generate_password_token'
    ];

    //define class to filter
    public function modelFilter()
    {
        return $this->provideFilter(\Modules\UserManagement\Entities\UserFilter::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        $backOfficeUser = BackOfficeUser::where('user_id', $this->id)->first();
        $userDetail = UserDetail::where('user_id', $this->id)->first();
        if ($backOfficeUser !== null) {
            return [
                'email' => $this->email,
                'firstName' => ($userDetail !== null) ? $userDetail->first_name : 'BackOffice',
                'lastName' => ($userDetail !== null) ? $userDetail->last_name : 'User',
                'role' => BackOfficeRole::where('id', BackOfficeRole::where('id', $backOfficeUser['role_id'])->first()['id'])->first()['slug'],
                'valid_address' => $this->userHaveValidAddress($userDetail),
            ];
        }
        return [
            'email' => $this->email,
            'locked_account' => PortalUser::where('user_id', $this->id)->first()['locked_account'],
            'valid_address' => $this->userHaveValidAddress($userDetail),
        ];
    }

    public function userHaveValidAddress($userDetail)
    {
        if ($userDetail == null) {
            return false;
        }
        return !empty($userDetail->first_name) && !empty($userDetail->last_name) &&
            !empty($userDetail->street) && !empty($userDetail->street) && !empty($userDetail->city);
    }


    public function portalUser()
    {
        return $this->hasOne('\Modules\UserManagement\Entities\PortalUser');
    }

    public function backOfficeUser()
    {
        return $this->hasOne('\Modules\UserManagement\Entities\BackOfficeUser');
    }

    public function serviceAccount()
    {
        return $this->hasOne('\Modules\UserManagement\Entities\ServiceAccount');
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
