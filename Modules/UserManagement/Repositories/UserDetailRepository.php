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

    public function update($request, $user_id)
    {
        return $this->model
            ::where('user_id', $user_id)
            ->update($request);
    }

    public function create($user_id)
    {
        return $this->model
            ::create([
                'user_id'   =>  $user_id
            ]);
    }
}