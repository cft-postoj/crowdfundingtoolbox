<?php


namespace Modules\UserManagement\Services;


interface BackOfficeUserServiceInterface
{
    public function get();
    public function getById($id);
    public function update($request);
    public function create($request);
    public function checkGeneratedResetToken($request, $prefix);
}