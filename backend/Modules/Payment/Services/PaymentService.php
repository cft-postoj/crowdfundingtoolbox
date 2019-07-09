<?php


namespace Modules\Payment\Services;

use Illuminate\Http\Response;

use Modules\Payment\Entities\Payment;
use Modules\Payment\Entities\PaymentMethod;
use Modules\Payment\Repositories\PaymentRepository;
use Modules\UserManagement\Entities\UserPaymentOption;
use Modules\UserManagement\Services\PortalUserService;
use Modules\UserManagement\Services\UserPaymentOptionService;

class PaymentService
{
    protected $paymentRepository;
    protected $donationService;
    protected $portalUserService;
    protected $userPaymentOptionService;

    public function __construct(PaymentRepository $paymentRepository, UserPaymentOptionService $userPaymentOptionService,
                                DonationService $donationService, PortalUserService $portalUserService)
    {
        $this->paymentRepository = $paymentRepository;
        $this->donationService = $donationService;
        $this->portalUserService = $portalUserService;
        $this->userPaymentOptionService = $userPaymentOptionService;
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

    private function getPayment($id)
    {
        return Payment::where('id', $id)->first();
    }

    public function pairPaymentToUser($request)
    {
        $valid = validator($request->only(
            'user_id',
            'payment_id'
        ), [
            'user_id' => 'required|integer',
            'payment_id' => 'required|integer'
        ]);

        if ($valid->fails()) {
            $jsonError = response()->json([
                'error' => $valid->errors()
            ], 400);
            return $jsonError;
        }

        try {
            $donations = $this->donationService->getDonationsByUserId($request['user_id']);
            $actualPayment = $this->getPayment($request['payment_id']);
            $portal_user_id = $this->portalUserService->getPortalUserIdByUserId($request['user_id']);
            if ($donations == null) {
                $donationRequest = array(
                    'amount' => $actualPayment->amount,
                    'is_monthly_donation' => false,
                    'portal_user_id' => $portal_user_id,
                    'widget_id' => 1,
                    'payment_method' => $actualPayment->transfer_type,
                    'status' => 'processed',
                    'payment_id' => $actualPayment->id
                );
                $this->donationService->create($donationRequest);
            } else {
                $paired = false;
                $isPaymentIdNull = false;
                foreach ($donations as $donation) {
                    // find first donation with same amount
                    if ($donation->payment_id == null) {
                        $isPaymentIdNull = true;
                    }
                    if (($donation->amount == $actualPayment->amount) && $isPaymentIdNull) {
                        $this->donationService->updatePaymentIdAndAmount(array(
                            'payment_id' => $request['payment_id'],
                            'amount' => $actualPayment->amount
                        ), $donation->id);
                    }
                }
                if (!$paired) {
                    // pair to last donation with correct amount
                    if ($isPaymentIdNull) {
                        foreach ($donations as $donation) {
                            // find first donation with same amount
                            if ($donation->payment_id == null) {
                                $isPaymentIdNull = true;
                            }
                            if ($isPaymentIdNull) {
                                $this->donationService->updatePaymentIdAndAmount(array(
                                    'payment_id' => $request['payment_id'],
                                    'amount' => $actualPayment->amount
                                ), $donation->id);
                            }
                        }
                    } else {
                        $donationRequest = array(
                            'amount' => $actualPayment->amount,
                            'is_monthly_donation' => false,
                            'portal_user_id' => $portal_user_id,
                            'widget_id' => 1,
                            'payment_method' => $actualPayment->transfer_type,
                            'status' => 'processed',
                            'payment_id' => $actualPayment->id
                        );
                        $this->donationService->create($donationRequest);
                    }
                }
            }
            // ADD NEW IBAN TO PORTAL USER
            $request = array(
                'bank_account_number' => $actualPayment->iban,
                'pairing_type' => 'iban'
            );
            $this->userPaymentOptionService->update($request, $portal_user_id);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'message' => 'Successfully paired payment to user.'
        ], Response::HTTP_OK);
    }

}