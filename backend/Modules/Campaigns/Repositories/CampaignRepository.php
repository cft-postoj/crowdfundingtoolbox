<?php

namespace Modules\Campaigns\Repositories;

use Modules\Campaigns\Entities\Campaign;
use Modules\Campaigns\Entities\CampaignVersion;
use Modules\Campaigns\Providers\CampaignPromoteRepository;
use Modules\Targeting\Providers\TargetingRepository;
use Modules\UserManagement\Http\Controllers\UserRepositoryController;

class CampaignRepository implements CampaignRepositoryInterface
{

    /**
     * @param $rawCampaignData
     * @return Campaign
     */
    public function create($rawCampaignData): Campaign
    {
        $campaign = Campaign::create([
            'name' => $rawCampaignData['name'],
            'description' => $rawCampaignData['description'],
            'active' => $rawCampaignData['active']
        ]);
        return $campaign;
    }

    public function get($id)
    {
        return Campaign::with('targeting.urls')->with('promote')->find($id);
    }

    /**
     * @param $rawCampaignData
     * @return Campaign
     */
    public function update($rawCampaignData): Campaign
    {
        $campaign = $this->get($rawCampaignData['id']);

        $campaign->update([
            'name' => $rawCampaignData['name'],
            'description' => $rawCampaignData['description'],
            'active' => $rawCampaignData['active'],
        ]);
        return $campaign;
    }


    public function addTracking($campaignId, $userId, $data)
    {
        $campaignVersion = CampaignVersion::create([
            'campaign_id' => $campaignId,
            'user_id' => $userId,
            'campaign_data' => json_encode($data)
        ]);
        return $campaignVersion;
    }

    public function getActiveCampaigns($signed, $notSigned, $url)
    {
        $actualDate = date('Y-m-d');
        $campaignQuery = Campaign::query()
            ->whereHas('promote', function ($query) use ($actualDate, $url) {
                $query->where('end_date_value', '>=', $actualDate)
                    ->orWhere('is_end_date', false);
            })
            ->whereHas('targeting', function ($query) use ($url) {
                $query->where('url_specific', false)
                    ->orWhereHas('urls', function ($query) use ($url) {
                        $query->where('path','like', '%'.$url.'%');
                    });
            })
            ->where('active', true);
        if ($signed != null) {
            $campaignQuery = $campaignQuery
                ->whereHas('targeting', function ($query) use ($signed) {
                    $query->where('signed', $signed);
                });
        }
        if ($notSigned != null) {
            $campaignQuery = $campaignQuery
                ->whereHas('targeting', function ($query) use ($notSigned) {
                    $query->where('not_signed', $notSigned);
                });
        }

        return $campaignQuery->get('id');
    }
}