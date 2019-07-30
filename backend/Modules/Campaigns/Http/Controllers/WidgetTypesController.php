<?php

namespace Modules\Campaigns\Http\Controllers;

use Modules\Campaigns\Entities\WidgetType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class WidgetTypesController extends Controller
{
    public function getWidgetTypes()
    {
        return WidgetType::all();
    }

    public static function getWidgetTypeIds()
    {
        return WidgetType::all()->sortBy('id')->pluck('id')->toArray();
    }

    public function getWidgetTypeById($id)
    {
        return WidgetType::find($id);
    }

}
