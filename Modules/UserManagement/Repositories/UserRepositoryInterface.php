<?php


namespace Modules\UserManagement\Repositories;


interface UserRepositoryInterface
{
    public function getAll();

    public function get($id);

    public function create($email, $password, $username);

    public function update($request, $user_id);

    public function isUsernameUsed($username);

    public function updatePassword($id, $password);

    public function getByEmail($email);

    public function getPortalUsers();

    public function getPortalUserById($id);

    public function addGeneratedToken($id, $token);
}