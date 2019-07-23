<?php


namespace Modules\Statistics\Repositories;

use Illuminate\Support\Facades\DB;
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
        return TrackingShow::query()
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->with(['widget', 'donation', 'widget.campaign', 'widget.campaign.targeting'])
            ->get();
    }
}