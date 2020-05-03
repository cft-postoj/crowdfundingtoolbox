<?php


namespace Modules\UserManagement\Repositories;


use Modules\UserManagement\Entities\GeneratedUserToken;

class GeneratedUserTokenRepository implements GeneratedUserTokenRepositoryInterface
{

    protected $model;

    function __construct()
    {
        $this->model = GeneratedUserToken::class;
    }

    public function getAll()
    {
        return $this->model::all();
    }

    public function getByUserId($userId)
    {
        return $this->model
            ::where('user_id', $userId)
            ->orderByDesc('id')
            ->first();
    }

    public function getByToken($token)
    {
        return $this->model
            ::where('generated_token', $token)
            ->first();
    }

    public function getUserIdByToken($token)
    {
        return $this->model
            ::where('generated_token', $token)
            ->pluck('user_id')
            ->first();
    }

    public function delete($id)
    {
        return $this->model
            ::where('id', $id)
            ->delete();
    }

    public function addGeneratedToken($userId, $token)
    {
        $generatedToken = $this->model
            ::create([
                'user_id' => $userId,
                'generated_token' => $token
            ]);
        return $generatedToken;
    }

    public function deleteByUserId($userId)
    {
        return $this->model
            ::where('user_id', $userId)
            ->delete();
    }
}