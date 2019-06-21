<?php


namespace Modules\UserManagement\Repositories;


interface UserDetailRepositoryInterface
{
    public function get($user_id);
    public function update($request, $user_id);
    public function create($user_id);
}