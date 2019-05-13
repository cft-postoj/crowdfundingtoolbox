<?php

namespace Modules\Campaigns\Transformers;

use Modules\Campaigns\Entities\WidgetResult;
use Modules\Campaigns\Entities\WidgetType;
use Illuminate\Http\Resources\Json\Resource;

class WidgetResultResource extends Resource
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
        return [
            'widget_type' => $widgetType,
            'response'   =>  WidgetResult::where('widget_id', $this->id)
                ->first()
                ->only('desktop', 'tablet', 'mobile')
        ];
    }
}
