<?php


namespace Modules\UserManagement\Repositories;


use Modules\UserManagement\Entities\UserPaymentOption;

class UserPaymentOptionsRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = UserPaymentOption::class;
    }

    public function create($portal_user_id)
    {
        return $this->model
            ::create([
                'portal_user_id' => $portal_user_id
            ]);
    }

    public function update($request, $portal_user_id)
    {
        return $this->model
            ::where('portal_user_id', $portal_user_id)
            ->update($request);
    }
}