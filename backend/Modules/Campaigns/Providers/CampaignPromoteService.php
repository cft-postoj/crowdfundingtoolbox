<?php

namespace Modules\Campaigns\Providers;

use Illuminate\Http\Response;
use Illuminate\Support\ServiceProvider;
use Modules\Campaigns\Entities\CampaignPromote;

class CampaignPromoteService
{
    public function createCampaignPromoteSettings($campaign_id, $request)
    {
        try {
           return CampaignPromote::create([
                    'campaign_id' => $campaign_id,
                    'start_date_value' => $request['start_date_value'],
                    'is_end_date' => $request['is_end_date'],
                    'end_date_value' => $request['end_date_value'],
                    'donation_goal_value' => $request['donation_goal_value']
                ]
            );
        } catch (\Exception $exception) {
            return response()->json([
                'error' =>  $exception
            ], Response::HTTP_BAD_REQUEST);
        }

    }

    public function updateCampaignPromoteSettings($campaign_id, $request)
    {
        try {
            CampaignPromote::where('campaign_id', $campaign_id)->update([
                'start_date_value' => $request['start_date_value'],
                'is_end_date' => $request['is_end_date'],
                'end_date_value' => $request['end_date_value'],
                'donation_goal_value' => $request['donation_goal_value']
            ]);
        } catch (\Exception $exception) {
            return \response()->json([
                'error' =>  $exception
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function smart($data, $id, $value)
    {
        try {
            if ($value === 'dates_value') {
                $campaignPromote = CampaignPromote::where('campaign_id', $id);
                $campaignPromote->update([
                    'start_date_value' => $data['start_date_value'],
                    'end_date_value' => $data['end_date_value']
                ]);
            } else {
                $campaignPromote = CampaignPromote::where('campaign_id', $id);
                $campaignPromote->update([
                    $value => $data[$value]
                ]);
            }
            return $campaignPromote;
        } catch (\Exception $exception) {
            return \response()->json([
                'error' =>  $exception
            ], Response::HTTP_BAD_REQUEST);
        }

    }


}
