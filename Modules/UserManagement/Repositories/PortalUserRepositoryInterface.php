<?php


namespace Modules\UserManagement\Repositories;


interface PortalUserRepositoryInterface
{
    public function all();

    public function get($userId);

    public function update($userId);

    public function delete($userId);
}