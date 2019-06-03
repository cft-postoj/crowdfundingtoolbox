<?php


namespace Modules\UserManagement\Services;


interface PortalUserServiceInterface
{
    public function getPortalUsers();

    public function getPortalUserById();
}