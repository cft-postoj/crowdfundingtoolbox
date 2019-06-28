<?php


namespace Modules\UserManagement\Services;


interface BackOfficeUserServiceInterface
{
    public function get();
    public function update($request);
    public function create($request);
}