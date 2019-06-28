<?php


namespace Modules\UserManagement\Repositories;



use Modules\UserManagement\Entities\BackOfficeUser;

class BackOfficeUserRepository implements BackOfficeUserRepositoryInterface
{

    protected $model;

    public function __construct()
    {
        $this->model = BackOfficeUser::class;
    }

    public function get($userId)
    {
        return $this->model
            ::where('user_id', $userId)
            ->with('role')
            ->with('user')
            ->with('user.userDetail')
            ->first();
    }

}