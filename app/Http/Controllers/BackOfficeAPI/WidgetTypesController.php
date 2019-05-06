<?php

namespace App\Http\Controllers\BackofficeAPI;

use App\BackOfficeAPI\WidgetType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
