<?php


namespace Modules\UserManagement\Services;


interface PortalUserServiceInterface
{
    public function getAll();

    public function getById($id);

    public function checkToken();

    public function authenticate($request);

    public function resetPassword($request);

    public function logout();

    public function registerDuringDonation(String $email, int $cookie);
}