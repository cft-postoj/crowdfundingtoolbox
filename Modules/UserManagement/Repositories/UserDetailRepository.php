<?php


namespace Modules\UserManagement\Repositories;


use Modules\UserManagement\Entities\UserDetail;

class UserDetailRepository implements UserDetailRepositoryInterface
{

    protected $model;

    public function __construct()
    {
        $this->model = UserDetail::class;
    }

    public function get($user_id)
    {
        return $this->model
            ::where('user_id', $user_id)
            ->first();
    }
}