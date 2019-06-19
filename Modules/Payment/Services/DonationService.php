<?php

namespace Modules\Payment\Services;


use Modules\Payment\Entities\DonationInitialize;
use Modules\UserManagement\Entities\TrackingShow;
use Modules\UserManagement\Entities\UserCookieCouple;
use Modules\UserManagement\Services\PortalUserService;

class DonationService
{

    private $portalUserService;

    public function __construct()
    {
        $this->portalUserService = new PortalUserService();
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


}