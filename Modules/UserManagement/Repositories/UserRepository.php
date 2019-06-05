<?php


namespace Modules\UserManagement\Repositories;


use Modules\UserManagement\Entities\User;

class UserRepository implements UserRepositoryInterface
{
    protected $model;

    function __construct()
    {
        $this->model = User::class;
    }

    public function getAll()
    {
        // TODO: Implement getAll() method.
    }

    public function getById($id)
    {
        // TODO: Implement getById() method.
    }

    public function getPortalUsers()
    {
        return $this->model
            ::has('portalUser')
            ->has('userDetail')
            ->with('userDetail')
            ->with('donorStatus')
            ->get();
    }

    public function getPortalUserById($id)
    {
        return $this->model
            ::where('id', $id)
            ->with('userDetail')
            ->with('donorStatus')
            ->get();
    }
}