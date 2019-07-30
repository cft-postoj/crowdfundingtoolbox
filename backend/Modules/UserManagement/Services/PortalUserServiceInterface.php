<?php


namespace Modules\UserManagement\Services;


use Modules\UserManagement\Entities\User;

interface PortalUserServiceInterface
{
    public function getAll();

    public function getById($id);

    public function checkToken();

    public function authenticate($request);

    public function resetPassword($request);

    public function logout();

    public function registerDuringDonation($showId, string $email, $cookie, bool $terms, string $iban): User;
}