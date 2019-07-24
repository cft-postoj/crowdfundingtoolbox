<?php

namespace Modules\Payment\Services;


use Carbon\Carbon;
use Illuminate\Http\Response;
use Modules\Payment\Entities\Donation;
use Modules\Payment\Entities\DonationInitialize;
use Modules\Payment\Repositories\DonationRepository;
use Modules\UserManagement\Entities\PortalUser;
use Modules\UserManagement\Repositories\PortalUserRepository;
use Modules\UserManagement\Services\PortalUserService;
use Modules\UserManagement\Services\TrackingService;

class DonationService
{

    private $portalUserService;
    private $donationRepository;
    private $portalUserRepository;
    private $trackingService;
    private $paymentMethodsService;
    private $bankButtonService;
    private $payBySquareService;

    public function __construct(PortalUserService $portalUserService,
                                DonationRepository $donationRepository,
                                PortalUserRepository $portalUserRepository,
                                TrackingService $trackingService,
                                PaymentMethodsService $paymentMethodsService,
                                BankButtonService $bankButtonService,
                                PayBySquareService $payBySquareService)
    {
        $this->portalUserService = $portalUserService;
        $this->donationRepository = $donationRepository;
        $this->portalUserRepository = $portalUserRepository;
        $this->trackingService = $trackingService;
        $this->paymentMethodsService = $paymentMethodsService;
        $this->bankButtonService = $bankButtonService;
        $this->payBySquareService = $payBySquareService;
    }

    //if request is from dashboard, mock this function entirely
    public function initializeBackend($data, $url)
    {
        $bankOption = $this->paymentMethodsService->getBankOption($data['frequency']);
        $bankButtons = $this->bankButtonService->getBankButtons();
        $qrCode = $this->payBySquareService->getQRCodeFromData('0001', '20', $data['frequency']);
        if (strpos($url, env('CFT_URL')) == 0) {
            return array(
                'variable_symbol' => '0001',
                'bank_account' => $bankOption->accountNumber,
                'bankButtons' => $bankButtons,
                'qrCode' => $qrCode,
//                'user_token' => JWTAuth::fromUser($portalUser['user'])
            );
        }
        return $this->initialize($data);

    }

    public function initialize($data)
    {
        try {
            // TODO: otestovat
            $portalUser = $this->handleUserDuringInitialize($data);
            $bankButtons = $this->bankButtonService->getBankButtons();


            $donation = Donation::create([
                'show_id' => $data['show_id'],
                'user_id' => $portalUser['user']['id'],
//                'terms' => $data['terms'],
                'status' => 'initialized',
                'is_monthly_donation' => $data['frequency'] == 'monthly',
                'amount' => $data['donation_value']
            ]);

            $qrCode = $this->payBySquareService->getQRCodeFromData($portalUser->variableSymbol->variableSymbol, $data['amount'], $data['frequency']);
            $bankOption = $this->paymentMethodsService->getBankOption($data['frequency']);
            return array(
                'variable_symbol' => $portalUser->variableSymbol->variableSymbol,
                'bank_account' => $bankOption->accountNumber,
                'bankButtons' => $bankButtons,
                'user_token' => JWTAuth::fromUser($portalUser['user']),
                'qrCode' => $qrCode,
            );
        } catch (\Exception $e) {
            dd($e->getMessage(), $e->getTrace());
        }
    }

    /** Create new user
     * @param $data
     * @return id of user
     */
    private function handleUserDuringInitialize($data): PortalUser
    {
        //TODO: otestovat
        $trackingShow = $this->trackingService->getTrackingShowById($data['show_id']);
        $user = $trackingShow->visit['portalUser'];
        if ($user == null) {
            //create new user and connect his new user_id with his cookie
            $user = $this->portalUserService->registerDuringDonation($data['email'], $trackingShow->visit['user_cookie']);
        }
        return $user;
    }

    public function isUserOneTimeSupporter($donationsData)
    {
        foreach ($donationsData as $donation) {
            if ($donation->is_monthly_donation) {
                return false;
            }
        }
        return true;
    }

    public function isInSpecificLastPaymentTarget($donationsData, $olderThan, $notOlderThan, $type)
    {
        foreach ($donationsData as $donation) {
            if ($type == 'monthly') {
                if ($donation->is_monthly_donation) {
                    // return first donation which is monthly type
                    return $this->calculateDays($olderThan, $notOlderThan, $donation);
                }
            } else {
                if ($this->isUserOneTimeSupporter($donationsData)) {
                    if (!$donation->is_monthly_donation) {
                        return $this->calculateDays($olderThan, $notOlderThan, $donation);
                    }
                } else {
                    return false;
                }

            }
        }
        return false;
    }

    private function calculateDays($olderThan, $notOlderThan, $donation)
    {
        // WORKING WITH LAST DONATION
        $now = Carbon::now();
        return ($olderThan !== null && $notOlderThan !== null) ?
            (($now->subDays($olderThan) > Carbon::createFromFormat('Y-m-d H:i:s', $donation->created_at))
            && ($now->subDays($notOlderThan) < Carbon::createFromFormat('Y-m-d H:i:s', $donation->created_at))
                ? true : false)
            : (($olderThan !== null && $notOlderThan === null)
                ?
                (($now->subDays($olderThan) > Carbon::createFromFormat('Y-m-d H:i:s', $donation->created_at))
                    ? true : false)
                : (($now->subDays($notOlderThan) < Carbon::createFromFormat('Y-m-d H:i:s', $donation->created_at))
                    ? true : false
                )
            );
    }

    public function isInSpecificDonationTarget($donationsData, $biggerThan, $lessThan, $type)
    {
        if ($type === 'monthly') {
            return $this->isCorrectDonationTarget($biggerThan, $lessThan, $donationsData, true);
        }
        return $this->isCorrectDonationTarget($biggerThan, $lessThan, $donationsData, false);
    }

    private function isCorrectDonationTarget($biggerThan, $lessThan, $donations, $monthlyDonation)
    {
        foreach ($donations as $donation) {
            if ($donation->is_monthly_donation === $monthlyDonation) {
                if ($biggerThan !== null && $lessThan !== null) {
                    if ($donation->donation > $biggerThan && $donation->donation < $lessThan) {
                        return true;
                    }
                } else if ($biggerThan !== null && $lessThan === null) {
                    if ($donation->donation > $biggerThan) {
                        return true;
                    }
                } else {
                    if ($donation->donation < $lessThan) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public function isNotSupporter($donationsData)
    {

    }

    public function getDetail($id)
    {
        return response()->json(
            $this->donationRepository->getDetail($id),
            Response::HTTP_OK
        );
    }

    public function updateAssignment($request, $id)
    {
        $valid = validator($request->only(
            'user_id'
        ), [
            'user_id' => 'required|integer'
        ]);

        if ($valid->fails()) {
            $jsonError = response()->json([
                'error' => $valid->errors()
            ], 400);
            return $jsonError;
        }

        try {
            $portal_user_id = $this->portalUserService->getPortalUserIdByUserId($request['user_id']);
            $this->donationRepository->updateAssignment($portal_user_id, $id);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'message' => 'Successfully updated donation with id ' . $id . '.'
        ],
            Response::HTTP_CREATED
        );
    }

    public function updatePaymentIdAndAmount($request, $id)
    {
        return Donation::where('id', $id)->update(
            $request
        );
    }

    public function getDonationsByUserId($user_id)
    {
        return Donation::where('portal_user_id', $this->portalUserService->getPortalUserIdByUserId($user_id))
            ->get();
    }

    public function getDonationsByPortalUserId($portal_user_id)
    {
        return Donation::where('portal_user_id', $portal_user_id)->get();
    }

    public function create($request)
    {
        return $this->donationRepository->create($request);
    }

    public function cancelAssignment($id)
    {
        try {
            $this->donationRepository->delete($id);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'message' => 'Successfully cancel assignment of donation with id ' . $id
        ], Response::HTTP_OK);
    }

}