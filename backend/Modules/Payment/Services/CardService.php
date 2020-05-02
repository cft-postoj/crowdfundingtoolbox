<?php


namespace Modules\Payment\Services;


use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Modules\Payment\Repositories\PaymentOptionsRepository;

class CardService
{
    private $paymentMethodId;
    protected $paymentOptionsRepository;

    public function __construct(PaymentOptionsRepository $paymentOptionsRepository)
    {
        $this->paymentOptionsRepository = $paymentOptionsRepository;
        $this->paymentMethodId = 2;
    }

    public function getCreditCardDetails()
    {
        $title = json_decode($this->paymentOptionsRepository->getPaymentMethodDetails($this->paymentMethodId))['title'];


        return array(
            'title' => $title,
            'oneTimePayment' => array(
                'emailNotify' => env('CARDPAY_NOTIFY_EMAIL')
            ),
            'monthlyPayment' => array(
                'emailNotify' => env('CARDPAY_NOTIFY_EMAIL')
            )
        );
    }

    public function setCreditCardDetails($request)
    {
        try {
            $request->validate([
                'payment_settings.monthlyPayment.emailNotify' => 'required|email',
                'payment_settings.oneTimePayment.emailNotify' => 'required|email'
            ]);
            $requestArr = array(
                'payment_method' => $this->paymentMethodId,
                'payment_settings' => json_encode($request['payment_settings']) // is in JSON type
            );
            file_put_contents(app()->environmentFilePath(), str_replace(
                'CARDPAY_NOTIFY_EMAIL' . '=' . env('CARDPAY_NOTIFY_EMAIL'),
                'CARDPAY_NOTIFY_EMAIL' . '=' . $request['payment_settings.monthlyPayment.emailNotify'],
                file_get_contents(app()->environmentFilePath())
            ));

            if ($this->paymentOptionsRepository->getPaymentMethodDetails($this->paymentMethodId) !== null) {
                return $this->paymentOptionsRepository->updatePaymentMethodDetails(array(
                    'payment_settings' => json_encode($request['payment_settings'])
                ), $this->paymentMethodId);
            } else {
                return $this->paymentOptionsRepository->createPaymentMethodDetails($requestArr);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}