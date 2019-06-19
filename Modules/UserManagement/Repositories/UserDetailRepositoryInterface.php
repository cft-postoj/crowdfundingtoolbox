<?php


namespace Modules\UserManagement\Repositories;


interface UserDetailRepositoryInterface
{
    public function get($user_id);
}