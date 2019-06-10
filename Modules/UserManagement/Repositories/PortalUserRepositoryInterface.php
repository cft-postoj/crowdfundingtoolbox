<?php


namespace Modules\UserManagement\Repositories;


interface PortalUserRepositoryInterface
{

    public function get($userId);

    public function create($userId);

}