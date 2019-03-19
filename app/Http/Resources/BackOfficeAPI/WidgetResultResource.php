<?php

namespace App\Http\Resources\BackOfficeAPI;

use App\BackOfficeAPI\WidgetResult;
use App\BackOfficeAPI\WidgetType;
use Illuminate\Http\Resources\Json\JsonResource;

class WidgetResultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
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
