<?php


namespace Modules\UserManagement\Repositories;


interface UserRepositoryInterface
{
    public function getAll();
    public function getById($id);
    public function getPortalUsers();
    public function getPortalUserById($id);
}