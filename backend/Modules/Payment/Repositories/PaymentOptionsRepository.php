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

    public function getPaymentMethodDetails($payment_method_id)
    {
        return $this->model
            ::where('payment_method', $payment_method_id)
            ->pluck('payment_settings')
            ->first();
    }

    public function createPaymentMethodDetails($request)
    {
        return $this->model
            ::create($request);
    }

    public function updatePaymentMethodDetails($request, $payment_method)
    {
        return $this->model
            ::where('payment_method', $payment_method)
            ->update(
                $request
            );
    }
}