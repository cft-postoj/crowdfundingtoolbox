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

    public function create($request)
    {
        //dd($request);
        return $this->model
            ::create(
                $request
            );
    }

    public function update($request, $portal_user_id)
    {
        return $this->model
            ::where('portal_user_id', $portal_user_id)
            ->update($request);
    }

    public function getByPortalUser($portal_user_id)
    {
        return $this->model
            ::where('portal_user_id', $portal_user_id)
            ->first();
    }

    public function getByIban($iban)
    {
        return $this->model
            ::where('bank_account_number', $iban)
            ->first();
    }

    public function getOptionsByIban($iban)
    {
        return $this->model
            ::where('bank_account_number', $iban)
            ->get();
    }

    public function getByCardId($card_id)
    {
        return $this->model
            ::where('card_id', $card_id)
            ->first();
    }
}
