<?php


namespace Modules\UserManagement\Services;


interface UserDetailServiceInterface
{
    public function getDetailsByToken();
    public function update($request, $userId);
    public function getBase();
}