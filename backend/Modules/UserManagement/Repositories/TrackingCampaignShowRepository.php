<?php


namespace Modules\UserManagement\Repositories;


use Carbon\Carbon;
use Modules\UserManagement\Entities\TrackingCampaignShow;

class TrackingCampaignShowRepository
{

    //indicates how long campaign should not change for user
    private $refreshMinutes = 30;

    public function getByPortalUserId($portalUserId)
    {
        return TrackingCampaignShow::where('portal_user_id', $portalUserId)->get();
    }

    public function getByUserCookieId($userCookieId)
    {
        return TrackingCampaignShow::where('user_cookie_id', $userCookieId)->get();
    }

    public function createByPortalUserId(int $portalUserId, int $campaignId, $userCookieId = null)
    {
        return TrackingCampaignShow::query()->create(['portal_user_id' => $portalUserId,
            'campaign_id' => $campaignId,
            'valid_until' => Carbon::now()->addMinutes($this->refreshMinutes),
            'user_cookie_id' => $userCookieId]);
    }

    public function createByUserCookieId($userCookieId, $campaignId)
    {
        return TrackingCampaignShow::query()->create(['user_cookie_id' => $userCookieId,
            'campaign_id' => $campaignId,
            'valid_until' => Carbon::now()->addMinutes($this->refreshMinutes)]);
    }

    public function updateValidUntil($updateCampaignShowId)
    {
        return TrackingCampaignShow::query()
            ->where('id', $updateCampaignShowId)
            ->update(['valid_until' => Carbon::now()->addMinutes($this->refreshMinutes)]
            );
    }


}