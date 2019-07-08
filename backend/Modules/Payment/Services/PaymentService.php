<?php


namespace Modules\Payment\Services;

use Illuminate\Http\Response;

use Modules\Payment\Repositories\PaymentRepository;

class PaymentService
{
    protected $paymentRepository;

    public function __construct(PaymentRepository $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    public function create($request)
    {
        $valid = validator($request->only(
            'transaction_id',
            'variable_symbol',
            'iban',
            'amount',
            'transfer_type',
            'transaction_date',
            'created_by'
        ), [
            'transaction_id' => 'required|string|max:255',
            'variable_symbol' => 'bigInteger|max:255',
            'iban' => 'string|max:255',
            'amount' => 'required|decimal|max:255',
            'transfer_type' => 'required|integer',
            'transaction_date' => 'required|timestamp',
            'created_by' => 'required|string'
        ]);

        if ($valid->fails()) {
            $jsonError = response()->json([
                'error' => $valid->errors()
            ], 400);
            return $jsonError;
        }

        try {
            $this->createPayment($request);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'message' => 'Successfully created payment.'
        ], Response::HTTP_CRETED);

    }

    public function createPayment($request)
    {
        $payment = $this->paymentRepository->create($request);
        return $payment;
    }

    public function update($request)
    {

    }

    public function getUnpairedPayments()
    {
        return response()->json(
            $this->paymentRepository->getUnpairedPayments(),
            Response::HTTP_OK);
    }
}