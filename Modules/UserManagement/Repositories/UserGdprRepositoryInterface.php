<?php


namespace Modules\UserManagement\Repositories;


interface UserGdprRepositoryInterface
{
    public function all();
    public function get($portal_user_id);
    public function create($request, $portal_user_id);
    public function update($request, $portal_user_id);
}