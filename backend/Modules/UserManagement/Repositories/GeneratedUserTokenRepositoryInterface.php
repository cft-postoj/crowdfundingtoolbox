<?php


namespace Modules\UserManagement\Repositories;


interface GeneratedUserTokenRepositoryInterface
{
    public function getAll();
    public function getUserIdByToken($token);
    public function addGeneratedToken($userId, $token);
    public function delete($id);
    public function deleteByUserId($userId);
}