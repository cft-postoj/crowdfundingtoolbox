<?php


namespace Modules\Statistics\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Campaigns\Entities\Campaign;
use Modules\Payment\Entities\Donation;
use Modules\UserManagement\Entities\TrackingShow;
use Modules\UserManagement\Entities\TrackingVisit;

class GeneralStatsRepository
{
    public function articlesStatistics($from, $to)
    {
        return TrackingVisit::query()
            ->whereNotNull('article_id')
            ->whereRaw('LENGTH(article_id) < 10 AND LENGTH(article_id) > 0')// only 10 characters (for ids)
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->with('show')
            ->with('show.donation')
            ->with('portalUser')
            ->with('portalUser.user')
            ->get();
    }

    public function campaignsStatistics($from, $to)
    {
        return Campaign::orderBy('active', 'desc')
            ->orderBy('updated_at', 'desc')
            ->with('targeting')
            ->with('widget.show')
            ->with('widget.donation')
            ->with('widget.donation.widget')
            ->with('widget.donation.widgetReferral')
            ->get();
    }

    public function campaignStats($from, $to, $id)
    {
        return Campaign::where('id', $id)
            ->with(['widget.donation' => function ($query) use ($from, $to) {
                $query
                    ->whereDate('created_at', '>=', $from)
                    ->whereDate('created_at', '<=', $to);
            }])
            ->with(['widget.show' => function ($query) use ($from, $to) {
                $query
                    ->whereDate('created_at', '>=', $from)
                    ->whereDate('created_at', '<=', $to);
            }])
            ->with('targeting')
            ->first();
    }
}