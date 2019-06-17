<?php


namespace Modules\UserManagement\Services;


use Modules\UserManagement\Entities\UserCookie;

class UserService
{

    public function createCookieIfNew($userCookie, $userId)
    {
        if ($userCookie=="" && $userId== null) {
           return UserCookie::create([
           ]);
        }
    }
}