<?php


namespace Modules\UserManagement\Repositories;


interface BackOfficeUserRepositoryInterface
{
    public function get($userId);
}