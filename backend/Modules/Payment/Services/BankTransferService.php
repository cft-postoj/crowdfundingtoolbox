<?php


namespace Modules\Payment\Services;


use Modules\Payment\Repositories\PaymentOptionsRepository;
use Illuminate\Http\Response;

class BankTransferService
{
    private $paymentMethodId;
    protected $paymentOptionsRepository;

    public function __construct(PaymentOptionsRepository $paymentOptionsRepository)
    {
        $this->paymentMethodId = 1; // bank transfer
        $this->paymentOptionsRepository = $paymentOptionsRepository;
    }

    public function getBackOfficeDetails()
    {
        return response()->json(
            json_decode($this->paymentOptionsRepository->getPaymentMethodDetails($this->paymentMethodId)),
            Response::HTTP_OK);
    }

    public function setBackOfficeDetails($request)
    {
        try {
            $requestArr = array(
                'payment_method' => $this->paymentMethodId,
                'payment_settings' => json_encode($request['payment_settings']) // is in JSON type
            );
            if (sizeof($this->paymentOptionsRepository->getPaymentMethodDetails($this->paymentMethodId)) > 0) {
                $this->paymentOptionsRepository->updatePaymentMethodDetails(array(
                    'payment_settings'   =>  json_encode($request['payment_settings'])
                ), $this->paymentMethodId);
            } else {
                $this->paymentOptionsRepository->createPaymentMethodDetails($requestArr);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'error' =>  $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'message' => 'Successfully updated bank transfer details.'
        ], Response::HTTP_OK);
    }
}