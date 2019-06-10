<?php


namespace Modules\UserManagement\Repositories;


use Modules\UserManagement\Entities\PortalUser;

class PortalUserRepository implements PortalUserRepositoryInterface
{
    protected $model;

    function __construct()
    {
        $this->model = PortalUser::class;
    }

    public function get($userId)
    {
        return $this->model
            ::where('user_id', $userId)
            ->first();
    }

    public function create($userId)
    {
        $this->model
            ::create([
                'user_id'   =>  $userId
            ])
            ->save();
    }

}