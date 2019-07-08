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
            /* TODO: pridat podmienku pre situaciu, kedy uz pouzivatel existuje, no nie ako portal user alebo backoffice - teda email/username is exist */
            $jsonError = response()->json([
                'error' => $valid->errors()
            ], 400);
            return $jsonError;
        }
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