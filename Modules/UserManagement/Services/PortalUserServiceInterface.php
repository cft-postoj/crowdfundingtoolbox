<?php


namespace Modules\UserManagement\Services;


use Illuminate\Http\Request;

interface PortalUserServiceInterface
{
    public function getAll();

    public function getById($id);

    public function checkToken();

    public function getUserByToken();

    public function authenticate($request);

    public function resetPassword($request);

    public function logout();
}