<?php

namespace Modules\Campaigns\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Campaigns\Entities\WidgetSettings;
use Modules\Campaigns\Entities\WidgetType;

class WidgetResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
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
