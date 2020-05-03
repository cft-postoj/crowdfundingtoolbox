<?php


namespace Modules\UserManagement\Services;


use Carbon\Carbon;
use Modules\UserManagement\Repositories\TrackingCampaignShowRepository;

class TrackingCampaignShowService
{
    /**
     * @var TrackingCampaignShowRepository
     */
    private $rep;


    /**
     * TrackingCampaignShowService constructor.
     */
    public function __construct(TrackingCampaignShowRepository $rep)
    {
        $this->rep = $rep;
    }

    public function getByPortalUserId($portalUserId)
    {
        return $this->rep->getByPortalUserId($portalUserId);
    }


    public function getByUserCookieId($userCookieId)
    {
        return $this->rep->getByUserCookieId($userCookieId);
    }

    //$filteredCampaigns are already ordered by priority
    public function orderByShowedCampaigns($trackingCampaignShow, $filteredCampaigns)
    {

        $result = [];
        //find campaigns, that are not showed and removed them from $filteredCampaigns
        foreach ($filteredCampaigns as $key => $filteredCampaign) {
            $showCampaign = false;
            $isStillValid = false;
            foreach ($trackingCampaignShow as $campaignShow) {
                //if user never saw campaign push campaign in front
                if ($campaignShow->campaign_id === $filteredCampaign['id']) {
                    $showCampaign = true;
                    $isStillValid = Carbon::parse($campaignShow->valid_until)->isAfter(Carbon::now());
                    $filteredCampaigns[$key]['tracking_campaign_show'] = $campaignShow;

                }

            }
            if ($isStillValid) {
                array_push($result, $filteredCampaign);
                unset($filteredCampaigns[array_search($filteredCampaign, $filteredCampaigns)]);
            }


            if ($showCampaign === false) {
                $campaignPosition = array_search($filteredCampaign, $filteredCampaigns);
                $filteredCampaign['create_new_campaign_show'] = true;
                array_push($result, $filteredCampaign);
                unset($filteredCampaigns[$campaignPosition]);
            }

        }

        foreach ($filteredCampaigns as $filteredCampaign) {
            $filteredCampaign['update_campaign_show'] = true;
            $filteredCampaign['update_campaign_show_id'] = $filteredCampaign['tracking_campaign_show']->id;
        }

        usort($filteredCampaigns, function ($a, $b) {
            return Carbon::parse($a['tracking_campaign_show']->valid_until) <=> Carbon::parse($b['tracking_campaign_show']->valid_until);
        });

        $result = array_merge($result, $filteredCampaigns);
        return $result;
    }

    public function createByPortalUserId(int $portalUserId, int $campaignId, $userCookieId = null)
    {
        return $this->rep->createByPortalUserId($portalUserId, $campaignId, $userCookieId);
    }

    public function createByUserCookieId($userCookieId, $campaignId)
    {
        return $this->rep->createByUserCookieId($userCookieId, $campaignId);
    }

    public function updateValidUntil($updateCampaignShowId)
    {
        return $this->rep->updateValidUntil($updateCampaignShowId);
    }


}