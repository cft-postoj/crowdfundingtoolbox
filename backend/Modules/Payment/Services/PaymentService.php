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
                        $paired = true;
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

    public function pairPaymentsViaIban($request)
    {
        $valid = validator($request->only(
            'payment_ids'
        ), [
            'payment_ids' => 'required|array'
        ]);

        if ($valid->fails()) {
            $jsonError = response()->json([
                'error' => $valid->errors()
            ], 400);
            return $jsonError;
        }

        $allIds = sizeof($request['payment_ids']);
        $successPaired = 0;
        $message = '';

        try {
            foreach ($request['payment_ids'] as $payment_id) {
                $paymentData = $this->paymentRepository->get($payment_id);
                $portalUsers = $this->portalUserService->getAll();
                foreach ($portalUsers as $user) {
                    if ($user->portalUser->userPaymentOptions !== null) {
                        if ($paymentData->iban === $user->portalUser->userPaymentOptions->bank_account_number) {
                            $donations = $this->donationService->getDonationsByUserId($user->id);
                            if ($donations == null) {
                                $donationRequest = array(
                                    'amount' => $paymentData->amount,
                                    'is_monthly_donation' => false,
                                    'portal_user_id' => $user->portalUser->id,
                                    'widget_id' => 1,
                                    'payment_method' => $paymentData->transfer_type,
                                    'status' => 'processed',
                                    'payment_id' => $paymentData->id
                                );
                                $this->donationService->create($donationRequest);
                                $successPaired++;
                            } else {
                                $paired = false;
                                $isPaymentIdNull = false;
                                foreach ($donations as $donation) {
                                    // find first donation with same amount
                                    if ($donation->payment_id == null) {
                                        $isPaymentIdNull = true;
                                    }
                                    if (($donation->amount == $paymentData->amount) && $isPaymentIdNull) {
                                        $paired = true;
                                        $this->donationService->updatePaymentIdAndAmount(array(
                                            'payment_id' => $request['payment_id'],
                                            'amount' => $paymentData->amount
                                        ), $donation->id);
                                        $successPaired++;
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
                                                    'amount' => $paymentData->amount
                                                ), $donation->id);
                                                $successPaired++;
                                            }
                                        }
                                    } else {
                                        $donationRequest = array(
                                            'amount' => $paymentData->amount,
                                            'is_monthly_donation' => false,
                                            'portal_user_id' => $user->portalUser->id,
                                            'widget_id' => 1,
                                            'payment_method' => $paymentData->transfer_type,
                                            'status' => 'processed',
                                            'payment_id' => $paymentData->id
                                        );
                                        $this->donationService->create($donationRequest);
                                        $successPaired++;
                                    }
                                }
                            }
                            // ADD NEW IBAN TO PORTAL USER
                            $request = array(
                                'bank_account_number' => $paymentData->iban,
                                'pairing_type' => 'iban'
                            );
                            $this->userPaymentOptionService->update($request, $user->portalUser->id);
                        }
                    }
                }
            }
        } catch (\Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        if ($successPaired !== $allIds) {
            $message = 'Not every user has in his account included IBAN, which is used in these payments. <br /><b>PAIRING STATUS:</b> ';
            if ($successPaired === 1) {
                $successMessage = $successPaired . ' payment was ';
            } else {
                $successMessage = $successPaired . ' payments were ';
            }
            if ($allIds - $successPaired === 1) {
                $notSuccessMessage = ($allIds - $successPaired) . ' payment was ';
            } else {
                $notSuccessMessage = ($allIds - $successPaired) . ' payments were ';
            }
            $message .= $successMessage . 'successfully paired and ' . $notSuccessMessage . ' not paired.';
        } else {
            $message = '<b>PAIRING STATUS:</b> All payments were successfully paired!';
        }
        $status = 'success';
        if ($allIds - $successPaired !== 0) {
            $status = 'warning';
        }

        return response()->json([
            'message' => $message,
            'status' => $status
        ], Response::HTTP_CREATED);


    }

    public function getPayments($from, $to, $monthly)
    {
        return $this->paymentRepository->getPayments($from, $to, $monthly);
    }

    public function getPaymentTotalGroupMonthly($from, $to)
    {
        return $this->paymentRepository->getPaymentTotalGroupMonthly($from, $to);
    }

}