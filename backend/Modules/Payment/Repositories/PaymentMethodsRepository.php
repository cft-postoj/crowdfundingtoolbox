<?php


namespace Modules\Payment\Repositories;


use Modules\Payment\Entities\PaymentMethod;

class PaymentMethodsRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = PaymentMethod::class;
    }

    public function getAllMethods()
    {
        return $this->model
            ::with('paymentOption')
            ->get();
    }

    public function getMethodById($id)
    {
        return $this->model
            ::with('paymentOption')
            ->find($id);
    }
}