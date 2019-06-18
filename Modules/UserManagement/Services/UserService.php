<?php


namespace Modules\UserManagement\Services;


use Modules\UserManagement\Repositories\UserRepository;
use Modules\UserManagement\Entities\UserCookie;

class UserService implements UserServiceInterface
{
    private $userRepository;

    public function __construct()
    {
       $this->userRepository = new UserRepository();
    }

    public function getById($id)
    {
        return $this->userRepository->get($id);
    }

    public function createCookieIfNew($userCookie, $userId)
    {
        if ($userCookie=="" && $userId== null) {
           return UserCookie::create([
           ]);
        }
    }
}