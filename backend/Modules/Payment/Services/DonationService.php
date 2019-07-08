<?php

namespace Modules\Payment\Services;


use Carbon\Carbon;
use Modules\Payment\Entities\DonationInitialize;
use Modules\Payment\Repositories\DonationRepository;
use Modules\UserManagement\Entities\TrackingShow;
use Modules\UserManagement\Services\PortalUserService;
use Illuminate\Http\Response;

class DonationService
{

    private $portalUserService;
    private $donationRepository;

    public function __construct(PortalUserService $portalUserService, DonationRepository $donationRepository)
    {
        $this->portalUserService = $portalUserService;
        $this->donationRepository = $donationRepository;
    }

    public function initialize($data)
    {
        try {
            $userId = $this->handleUserDuringInitialize($data);

            return DonationInitialize::create([
                'show_id' => $data['show_id'],
                'user_id' => $userId,
                'terms' => $data['terms'],
                'frequency' => $data['frequency'],
                'donation_value' => $data['donation_value']
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage(), $e->getTrace());
        }
    }

    /** Create new user
     * @param $data
     * @return id of user
     */
    private function handleUserDuringInitialize($data): int
    {
        $trackingShow = TrackingShow::with('visit.user')->find($data['show_id']);
        $userId = $trackingShow->visit['user_id'];
        if (!$userId) {
            //create new user and connect his new user_id with his cookie
            $user = $this->portalUserService->registerDuringDonation($data['email'], $trackingShow->visit['user_cookie']);
            $userId = $user->id;
        }
        return $userId;
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

}