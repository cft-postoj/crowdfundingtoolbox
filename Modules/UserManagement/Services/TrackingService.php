<?php

namespace Modules\UserManagement\Services;

use Modules\UserManagement\Entities\TrackingBasic;
use Modules\UserManagement\Entities\TrackingClick;
use Modules\UserManagement\Entities\TrackingInsertValue;
use Modules\UserManagement\Entities\TrackingShow;

class TrackingService
{

    public function __construct()
    {

    }

    public function show($userId, $widgetId, $url, $title, $userCookie)
    {
        try {
            $trackingBasic = TrackingBasic::create([
                'user_id' => $userId,
                'user_cookie' => $userCookie,
                'url' => $url
            ]);
            $trackingShow = TrackingShow::create([
                'basic_id' => $trackingBasic->id,
                'widget_id' => $widgetId,
                'article_id' => '6',
                'title' => $title
            ]);
            $trackingShow->basic = $trackingBasic;
        } catch (\Exception $e) {
            dd($e->getMessage(), $e->getTrace());
        }
        return $trackingShow;
    }

    public function click($data)
    {
        try {
            $trackingClick = TrackingClick::create([
                "show_id" => $data['show_id'],
                "node_class" => $data['node_class'],
                "node_id" => $data['node_id']
            ]) ;
        } catch (\Exception $e) {
            dd($e->getMessage(), $e->getTrace());
        }
        return $trackingClick;
    }

    public function insertValue( $data)
    {
        try {
            $trackingInsertValue = TrackingInsertValue::create([
                "show_id" => $data['show_id'],
                "value" => $data['value'],
                "frequency" => $data['frequency']
            ]) ;
        } catch (\Exception $e) {
            dd($e->getMessage(), $e->getTrace());
        }
        return $trackingInsertValue;

    }

}