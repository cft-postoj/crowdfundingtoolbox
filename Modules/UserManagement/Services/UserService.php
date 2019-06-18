<?php


namespace Modules\UserManagement\Services;


use Modules\UserManagement\Repositories\UserRepository;

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
}