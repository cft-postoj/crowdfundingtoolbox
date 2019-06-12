<?php


namespace Modules\UserManagement\Services;


interface PortalUserServiceInterface
{
    public function getAll();

    public function getById($id);

    public function checkToken();
}