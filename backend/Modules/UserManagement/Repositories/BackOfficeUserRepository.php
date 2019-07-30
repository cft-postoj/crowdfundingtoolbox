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

    public function all() {
        return $this->model
            ::with('user')
            ->with('user.userDetail')
            ->get();
    }

    public function delete($id) {
        return $this->model
            ::where('user_id', $id)
            ->delete();
    }

}