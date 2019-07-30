<?php


namespace Modules\Payment\Services;

use Illuminate\Http\Response;
use Modules\Payment\Repositories\PaymentMethodsRepository;

class PaymentMethodsService
{
    protected $paymentMethodsRepository;

    public function __construct(PaymentMethodsRepository $paymentMethodsRepository)
    {
        $this->paymentMethodsRepository = $paymentMethodsRepository;
    }

    public function all()
    {
        return $this->paymentMethodsRepository->getAllMethods();
    }

    public function getAllMethods()
    {
        return response()->json(
            $this->all(),
            Response::HTTP_OK);
    }

    public function getBankOption($frequency, $methodId)
    {
        $bankOption = $this->paymentMethodsRepository->getMethodById($methodId);
        if ($frequency == 'monthly') {
            return json_decode($bankOption->paymentOption->payment_settings)->monthlyPayment;
        } else {
            return json_decode($bankOption->paymentOption->payment_settings)->oneTimePayment;
        }
    }

}