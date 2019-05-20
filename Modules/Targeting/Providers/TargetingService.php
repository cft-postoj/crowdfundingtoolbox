<?php

namespace Modules\Targeting\Providers;

use Illuminate\Http\Response;
use Modules\Targeting\Entities\TargetingUrl;
use Modules\Targeting\Entities\Targeting;

class TargetingService
{
    public function createTargetingFromRequest($campaignId, $requestTargeting)
    {
        try {
            $targeting = Targeting::create(
                ['campaign_id' => $campaignId,
                    'signed' => $requestTargeting['signed_status']['signed']['active'],
                    'not_signed' => $requestTargeting['signed_status']['not_signed']['active'],
                    'one_time' => $requestTargeting['support']['one_time']['active'],
                    'one_time_older_than' => $requestTargeting['support']['one_time']['older_than']['active'],
                    'one_time_older_than_value' => $requestTargeting['support']['one_time']['older_than']['value'],
                    'one_time_not_older_than' => $requestTargeting['support']['one_time']['not_older_than']['active'],
                    'one_time_not_older_than_value' => $requestTargeting['support']['one_time']['not_older_than']['value'],
                    'one_time' => $requestTargeting['support']['one_time']['active'],
                    'one_time_min' => $requestTargeting['support']['one_time']['min']['active'],
                    'one_time_min_value' => $requestTargeting['support']['one_time']['min']['value'],
                    'one_time_max' => $requestTargeting['support']['one_time']['max']['active'],
                    'one_time_max_value' => $requestTargeting['support']['one_time']['max']['value'],
                    'monthly' => $requestTargeting['support']['monthly']['active'],
                    'monthly_older_than' => $requestTargeting['support']['monthly']['older_than']['active'],
                    'monthly_older_than_value' => $requestTargeting['support']['monthly']['older_than']['value'],
                    'monthly_not_older_than' => $requestTargeting['support']['monthly']['not_older_than']['active'],
                    'monthly_not_older_than_value' => $requestTargeting['support']['monthly']['not_older_than']['value'],
                    'monthly_min' => $requestTargeting['support']['monthly']['min']['active'],
                    'monthly_min_value' => $requestTargeting['support']['monthly']['min']['value'],
                    'monthly_max' => $requestTargeting['support']['monthly']['max']['active'],
                    'monthly_max_value' => $requestTargeting['support']['monthly']['max']['value'],
                    'not_supporter' => $requestTargeting['support']['not_supporter']['active'],
                    'read_articles_today' => $requestTargeting['read_articles']['today']['active'],
                    'read_articles_today_min' => $requestTargeting['read_articles']['today']['min'],
                    'read_articles_today_max' => $requestTargeting['read_articles']['today']['max'],
                    'read_articles_week' => $requestTargeting['read_articles']['week']['active'],
                    'read_articles_week_min' => $requestTargeting['read_articles']['week']['min'],
                    'read_articles_week_max' => $requestTargeting['read_articles']['week']['max'],
                    'read_articles_month' => $requestTargeting['read_articles']['month']['active'],
                    'read_articles_month_min' => $requestTargeting['read_articles']['month']['min'],
                    'read_articles_month_max' => $requestTargeting['read_articles']['month']['max'],
                    'registration_before' => $requestTargeting['registration']['before']['active'],
                    'registration_before_value' => $requestTargeting['registration']['before']['date'],
                    'registration_after' => $requestTargeting['registration']['after']['active'],
                    'registration_after_value' => $requestTargeting['registration']['after']['date'],
                    'url_specific' => $requestTargeting['url']['specific']
                ]);
            //create targetingUrl's
            foreach ($requestTargeting['url']['list'] as $url) {
                TargetingUrl::create([
                    'targeting_id' => $targeting->id,
                    'path' => $url['path']
                ]);
            }
        } catch (\Exception $e) {
            return \response()->json([
                'error' => $e
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function updateTargetingFromRequest($campaignId, $requestTargeting)
    {
        try {
            $targeting = Targeting::with('urls')->where('campaign_id', $campaignId)->first();
            $targeting->update([
                'signed' => $requestTargeting['signed_status']['signed']['active'],
                'not_signed' => $requestTargeting['signed_status']['not_signed']['active'],
                'one_time' => $requestTargeting['support']['one_time']['active'],
                'one_time_older_than' => $requestTargeting['support']['one_time']['older_than']['active'],
                'one_time_older_than_value' => $requestTargeting['support']['one_time']['older_than']['value'],
                'one_time_not_older_than' => $requestTargeting['support']['one_time']['not_older_than']['active'],
                'one_time_not_older_than_value' => $requestTargeting['support']['one_time']['not_older_than']['value'],
                'one_time' => $requestTargeting['support']['one_time']['active'],
                'one_time_min' => $requestTargeting['support']['one_time']['min']['active'],
                'one_time_min_value' => $requestTargeting['support']['one_time']['min']['value'],
                'one_time_max' => $requestTargeting['support']['one_time']['max']['active'],
                'one_time_max_value' => $requestTargeting['support']['one_time']['max']['value'],
                'monthly' => $requestTargeting['support']['monthly']['active'],
                'monthly_older_than' => $requestTargeting['support']['monthly']['older_than']['active'],
                'monthly_older_than_value' => $requestTargeting['support']['monthly']['older_than']['value'],
                'monthly_not_older_than' => $requestTargeting['support']['monthly']['not_older_than']['active'],
                'monthly_not_older_than_value' => $requestTargeting['support']['monthly']['not_older_than']['value'],
                'monthly_min' => $requestTargeting['support']['monthly']['min']['active'],
                'monthly_min_value' => $requestTargeting['support']['monthly']['min']['value'],
                'monthly_max' => $requestTargeting['support']['monthly']['max']['active'],
                'monthly_max_value' => $requestTargeting['support']['monthly']['max']['value'],
                'not_supporter' => $requestTargeting['support']['not_supporter']['active'],
                'read_articles_today' => $requestTargeting['read_articles']['today']['active'],
                'read_articles_today_min' => $requestTargeting['read_articles']['today']['min'],
                'read_articles_today_max' => $requestTargeting['read_articles']['today']['max'],
                'read_articles_week' => $requestTargeting['read_articles']['week']['active'],
                'read_articles_week_min' => $requestTargeting['read_articles']['week']['min'],
                'read_articles_week_max' => $requestTargeting['read_articles']['week']['max'],
                'read_articles_month' => $requestTargeting['read_articles']['month']['active'],
                'read_articles_month_min' => $requestTargeting['read_articles']['month']['min'],
                'read_articles_month_max' => $requestTargeting['read_articles']['month']['max'],
                'registration_before' => $requestTargeting['registration']['before']['active'],
                'registration_before_value' => $requestTargeting['registration']['before']['date'],
                'registration_after' => $requestTargeting['registration']['after']['active'],
                'registration_after_value' => $requestTargeting['registration']['after']['date'],
                'url_specific' => $requestTargeting['url']['specific']
            ]);

            //delete target urls that are not in new request
            foreach ($targeting->urls as $databaseUrl) {
                $shouldBeRemoved = true;
                foreach ($requestTargeting['url']['list'] as $requestUrl) {
                    if ($databaseUrl->path == $requestUrl['path']) {
                        $shouldBeRemoved = false;
                    };
                }
                if ($shouldBeRemoved) {
                    $databaseUrl->delete();
                }
            }

            //create new target urls. (in new targetingUrl id is set to 0 )
            foreach ($requestTargeting['url']['list'] as $url) {
                if ($url['id'] == 0) {
                    TargetingUrl::create([
                        'targeting_id' => $targeting->id,
                        'path' => $url['path']
                    ]);
                }
            }
        } catch (\Exception $e) {
            error_log($e);
            return \response()->json([
                'error' => $e
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function cloneTargeting($campaignOld, $campaignNew)
    {

        $targeting = Targeting::with('urls')->where('campaign_id', $campaignOld->id)->first();
        $replicatedTarget = $targeting->replicate();
        $replicatedTarget->campaign_id = $campaignNew['id'];
        $replicatedTarget->save();

        foreach ($targeting->urls as $newTarget) {
            $replicatedTargetingUrl = $newTarget->replicate();
            $replicatedTargetingUrl->targeting_id = $replicatedTarget->id;
            $replicatedTargetingUrl->save();
        }

    }
}
