<?php

namespace Modules\UserManagement\Services;

use Carbon\Carbon;
use Modules\UserManagement\Entities\TrackingClick;
use Modules\UserManagement\Entities\TrackingInitializeDonationInvalid;
use Modules\UserManagement\Entities\TrackingInsertEmail;
use Modules\UserManagement\Entities\TrackingInsertValue;
use Modules\UserManagement\Entities\TrackingShow;
use Modules\UserManagement\Entities\TrackingVisit;

class TrackingService
{

    public function createVisit($userId, $userCookie, $url, $title, $articleId)
    {
        try {
            return TrackingVisit::create([
                'portal_user_id' => $userId,
                'user_cookie' => $userCookie,
                'url' => $url,
                'article_id' => $articleId,
                'title' => $title
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage(), $e->getTrace());
        }
    }

    public function show($trackingVisitId, $widgetId)
    {
        try {
            $trackingShow = TrackingShow::create([
                'tracking_visit_id' => $trackingVisitId,
                'widget_id' => $widgetId,
            ]);
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
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage(), $e->getTrace());
        }
        return $trackingClick;
    }

    public function insertValue($data)
    {
        try {
            $trackingInsertValue = TrackingInsertValue::create([
                "show_id" => $data['show_id'],
                "value" => $data['value'],
                "frequency" => $data['frequency']
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage(), $e->getTrace());
        }
        return $trackingInsertValue;

    }

    public function insertEmail($data)
    {
        try {
            $trackingInsertValue = TrackingInsertEmail::create([
                "show_id" => $data['show_id'],
                "email" => $data['email'],
                "email_valid" => $data['email_valid']
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage(), $e->getTrace());
        }
        return $trackingInsertValue;
    }

    public function initializeDonationInvalid($data)
    {
        try {
            return TrackingInitializeDonationInvalid::create([
                'show_id' => $data['show_id'],
                'email' => $data['email'],
                'terms' => $data['terms'],
                'frequency' => $data['frequency'],
                'donation_value' => $data['donation_value']
            ]);
        } catch (\Exception $e) {
            dd($e);
        }

    }

    public function hasUserReadArticles($visits, $term, $min, $max)
    {
        $count = 0;
        if (sizeof($visits) === 0) {
            return false;
        }
        foreach ($visits as $visit) {
            if (!is_null($visit->article_id)) {
                // min date is today for today term, else is tomorrow for today term, today + 7 days for week term and today + 30 days for month term
                $minDate = ($term === 'today') ? Carbon::today() : (($term === 'week') ? Carbon::today()->subDays(7) : Carbon::today()->subDays(30));
                // max date is tomorrow and today for other terms
                $maxDate = ($term === 'today') ? Carbon::tomorrow() : Carbon::today();
                $articleDate = Carbon::createFromFormat('Y-m-d H:i:s', $visit->created_at);

                if ($articleDate <= $maxDate && $articleDate >= $minDate) {
                    $count++;
                }
            }

        }
        if ($count >= $min && $count <= $max && $count > 0) {
            return true;
        }
        return false;
    }

    public function getTrackingShowById($id)
    {
        return TrackingShow
            ::with('visit.portalUser.variableSymbol')
            ->with('widget')
            ->with('visit.portalUser.user.portalUser.variableSymbol')->find($id);
    }

    public function getTrackingShowWithDonationById($id)
    {
        return TrackingShow
            ::with('donation')->find($id);
    }
}