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

    public function all() {
        return $this->paymentMethodsRepository->getAllMethods();
    }

    public function getAllMethods()
    {
        return response()->json(
            $this->all(),
            Response::HTTP_OK);
    }
}