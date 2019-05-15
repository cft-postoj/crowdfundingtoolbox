<?php

namespace Modules\Campaigns\Transformers;

use Modules\Campaigns\Entities\CampaignSettings;
use Illuminate\Http\Resources\Json\Resource;

class CampaignResourceDetail extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $campaignSettings = CampaignSettings::where('campaign_id', $this->id)->first();
        return [
            'id' => $this->id,
            'active' => ($this->active == null) ? false : $this->active,
            'name' => $this->name,
            'date_from' => $this->date_from,
            'date_to' => $this->date_to,
            'description' => $this->description,
            'headline_text' => $this->headline_text,
            'payment_settings' => json_decode($campaignSettings->payment_settings, true),
            'promote_settings' => json_decode($campaignSettings->promote_settings, true),
            'widget_settings' => json_decode($campaignSettings->widget_settings, true),
            'targeting' => $this->createTargetingJson($this->targeting)

        ];
    }

    private function createTargetingJson($targeting)
    {
        $result['signed_status']['signed']['active'] = $targeting->signed;
        $result['signed_status']['not_signed']['active'] = $targeting->not_signed;
        $result['support']['one_time']['active'] = $targeting->one_time;
        $result['support']['one_time']['older_than']['active'] = $targeting->one_time_older_than;
        $result['support']['one_time']['older_than']['value'] = $targeting->one_time_older_than_value;
        $result['support']['one_time']['not_older_than']['active'] = $targeting->one_time_not_older_than;
        $result['support']['one_time']['not_older_than']['value'] = $targeting->one_time_not_older_than_value;
        $result['support']['one_time']['min']['active'] = $targeting->one_time_min;
        $result['support']['one_time']['min']['value'] = $targeting->one_time_min_value;
        $result['support']['one_time']['max']['active'] = $targeting->one_time_max;
        $result['support']['one_time']['max']['value'] = $targeting->one_time_max_value;
        $result['support']['monthly']['active'] = $targeting->monthly;
        $result['support']['monthly']['older_than']['active'] = $targeting->monthly_older_than;
        $result['support']['monthly']['older_than']['value'] = $targeting->monthly_older_than_value;
        $result['support']['monthly']['not_older_than']['active'] = $targeting->monthly_not_older_than;
        $result['support']['monthly']['not_older_than']['value'] = $targeting->monthly_not_older_than_value;
        $result['support']['monthly']['min']['active'] = $targeting->monthly_min;
        $result['support']['monthly']['min']['value'] = $targeting->monthly_min_value;
        $result['support']['monthly']['max']['active'] = $targeting->monthly_max;
        $result['support']['monthly']['max']['value'] = $targeting->monthly_max_value;
        $result['support']['not_supporter']['active'] = $targeting->not_supporter;
        $result['read_articles']['today']['active'] = $targeting->read_articles_today;
        $result['read_articles']['today']['min'] = $targeting->read_articles_today_min;
        $result['read_articles']['today']['max'] = $targeting->read_articles_today_max;
        $result['read_articles']['week']['active'] = $targeting->read_articles_week;
        $result['read_articles']['week']['min'] = $targeting->read_articles_week_min;
        $result['read_articles']['week']['max'] = $targeting->read_articles_week_max;
        $result['read_articles']['month']['active'] = $targeting->read_articles_month;
        $result['read_articles']['month']['min'] = $targeting->read_articles_month_min;
        $result['read_articles']['month']['max'] = $targeting->read_articles_month_max;
        $result['registration']['before']['active'] = $targeting->registration_before;
        $result['registration']['before']['date'] = $targeting->registration_before_value;
        $result['registration']['after']['active'] = $targeting->registration_after;
        $result['registration']['after']['date'] = $targeting->registration_after_value;
        $result['url']['specific'] = $targeting->specific;
        $result['url']['list'] = $targeting->urls;
        return $result;
    }
}
