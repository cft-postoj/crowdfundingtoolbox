<?php


namespace Modules\Payment\Repositories;


use Modules\Payment\Entities\PaymentOption;

class PaymentOptionsRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = PaymentOption::class;
    }

    public function getPaymentMethodDetails($paymentMethodId)
    {
        return $this->model
            ::where('payment_method', $paymentMethodId)
            ->first();
    }
}