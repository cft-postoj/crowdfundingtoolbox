<?php


namespace Modules\UserManagement\Services;


interface GeneratedUserTokenServiceInterface
{
    public function create($userId);
    public function isValid($request);
}