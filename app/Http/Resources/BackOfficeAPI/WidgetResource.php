<?php

namespace App\Http\Resources\BackOfficeAPI;

use App\BackOfficeAPI\Widget;
use App\BackOfficeAPI\WidgetSettings;
use App\BackOfficeAPI\WidgetType;
use Illuminate\Http\Resources\Json\JsonResource;

class WidgetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $widgetType = WidgetType::where('id', $this->widget_type_id)
            ->first()
            ->only('id', 'name', 'description', 'method');
        $widgetSettings = WidgetSettings::where('widget_id', $this->id)
            ->first();

        return [
            'id' => $this->id,
            'updated_at' => $this->updated_at,
            'campaign_id' => $this->campaign_id,
            'active' => $this->active,
            'payment_type' => $this->payment_type,
            'widget_type' => $widgetType,
            'use_campaign_settings' =>  $this->use_campaign_settings,
            'settings' => [
                'desktop' => ($widgetSettings == null) ? null : json_decode($widgetSettings->desktop, true),
                'tablet' => ($widgetSettings == null) ? null : json_decode($widgetSettings->tablet, true),
                'mobile' => ($widgetSettings == null) ? null : json_decode($widgetSettings->mobile, true)
            ]
        ];
    }
}
