<?php

namespace App\Http\Resources\BackOfficeAPI;

use App\BackOfficeAPI\CampaignSettings;
use Illuminate\Http\Resources\Json\JsonResource;

class CampaignResource extends JsonResource
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
            'widget_settings' => json_decode($campaignSettings->widget_settings, true)
        ];
    }
}
