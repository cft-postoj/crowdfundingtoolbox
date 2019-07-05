<?php


namespace Modules\Payment\Services;

use Illuminate\Http\Response;
use Modules\Payment\Repositories\PaymentMethodsRepository;

class PaymentMethodsSevice
{
    protected $paymentMethodsRepository;

    public function __construct(PaymentMethodsRepository $paymentMethodsRepository)
    {
        $this->paymentMethodsRepository = $paymentMethodsRepository;
    }

    public function getAllMethods()
    {
        return response()->json(
            $this->paymentMethodsRepository->getAllMethods(),
            Response::HTTP_OK);
    }
}