<?php


namespace Modules\UserManagement\Repositories;


use Modules\UserManagement\Entities\User;

class PortalUserRepository implements PortalUserRepositoryInterface
{

    public function all()
    {
        return User::has('portalUser')
            ->has('userDetail')
            ->with('userDetail')
            ->with('donorStatus')
            ->get();
    }

    public function get($userId)
    {
        // TODO: Implement get() method.
    }

    public function update($userId)
    {
        // TODO: Implement update() method.
    }

    public function delete($userId)
    {
        // TODO: Implement delete() method.
    }
}