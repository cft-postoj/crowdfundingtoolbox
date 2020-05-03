<?php


namespace Modules\Statistics\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Campaigns\Entities\Article;
use Modules\Campaigns\Entities\Campaign;
use Modules\Campaigns\Entities\Widget;
use Modules\Payment\Entities\Donation;
use Modules\UserManagement\Entities\TrackingShow;
use Modules\UserManagement\Entities\TrackingVisit;

class GeneralStatsRepository
{
    public function makeAggArticleStats($article_id)
    {
        //get id of first donation of every user, who made a donate
        $firstDonationOfUser = Donation::query()
            ->select(DB::raw('min(id) as first_user_donation_id'), 'portal_user_id')
            ->whereNotNull('payment_id')
            ->groupBy('portal_user_id')
            ->orderBy('portal_user_id');

        //return tracking_show_id,amount donation and first_donation,
        //first_donation value is 1 when this is first user's donation
        $donationSub = Donation::query()
            ->select('tracking_show_id', 'amount',
                DB::raw('(CASE 
                        WHEN donations.id = first_user_donation_id THEN 1 
                        ELSE 0 
                        END) AS first_donation'))
            ->leftJoinSub($firstDonationOfUser, 'firstDonationOfUser', function ($join) {
                $join->on('donations.id', '=', 'firstDonationOfUser.first_user_donation_id');
            });

        //get tracking show subquery
        $trackingShowSub = TrackingShow::query()
            ->select('tracking_visit_id as tracking_visit_id', 'amount', 'first_donation')
            ->joinSub($donationSub, 'donationSub', function ($join) {
                $join->on('tracking_show.id', '=', 'donationSub.tracking_show_id');
            });

        //get tracking show subquery, filter based on created_at
        $trackingVisitSub = TrackingVisit::query()
            ->select('article_id as visit_article_id', 'amount', 'first_donation', 'url')
            ->leftJoinSub($trackingShowSub, 'trackingShowSub', function ($join) {
                $join->on('tracking_visit.id', '=', 'trackingShowSub.tracking_visit_id');
            });

        //return article data
        return Article::where('id', $article_id)
            ->select('articles.id', 'articles.title', 'articles.url',
                DB::raw('sum(amount) as amount_sum'),
                DB::raw('sum(first_donation) as new_users'),
                DB::raw('count(visit_article_id) as  visits'))
            ->joinSub($trackingVisitSub, 'trackingVisitSub', function ($join) {
                $join->on('articles.id', '=', 'trackingVisitSub.visit_article_id');
            })
            ->groupBy('articles.id', 'articles.title', 'articles.id', 'articles.url')
            ->first();
    }

    public function articlesStatistics($from, $to)
    {


        //get id of first donation of every user, who made a donate
        $firstDonationOfUser = Donation::query()
            ->select(DB::raw('min(id) as first_user_donation_id'), 'portal_user_id')
            ->whereNotNull('payment_id')
            ->groupBy('portal_user_id')
            ->orderBy('portal_user_id');

        //return tracking_show_id,amount donation and first_donation,
        //first_donation value is 1 when this is first user's donation
        $donationSub = Donation::query()
            ->select('tracking_show_id', 'amount',
                DB::raw('(CASE 
                        WHEN donations.id = first_user_donation_id THEN 1 
                        ELSE 0 
                        END) AS first_donation'))
            ->leftJoinSub($firstDonationOfUser, 'firstDonationOfUser', function ($join) {
                $join->on('donations.id', '=', 'firstDonationOfUser.first_user_donation_id');
            });

        //get tracking show subquery
        $trackingShowSub = TrackingShow::query()
            ->select('tracking_visit_id as tracking_visit_id', 'amount', 'first_donation')
            ->joinSub($donationSub, 'donationSub', function ($join) {
                $join->on('tracking_show.id', '=', 'donationSub.tracking_show_id');
            });

        //get tracking show subquery, filter based on created_at
        $trackingVisitSub = TrackingVisit::query()
            ->select('article_id as visit_article_id', 'amount', 'first_donation', 'url')
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->leftJoinSub($trackingShowSub, 'trackingShowSub', function ($join) {
                $join->on('tracking_visit.id', '=', 'trackingShowSub.tracking_visit_id');
            });

        //return articles
        return Article::query()
            ->select('articles.id', 'articles.title', 'url',
                DB::raw('sum(amount) as amount_sum'),
                DB::raw('sum(first_donation) as new_users'),
                DB::raw('count(visit_article_id) as  visits'))
            ->joinSub($trackingVisitSub, 'trackingVisitSub', function ($join) {
                $join->on('articles.id', '=', 'trackingVisitSub.visit_article_id');
            })
            ->groupBy('articles.id', 'articles.title', 'articles.id', 'url')
            ->get();
    }

    //return campaigns grouped by widget. For every widget connected to campaign return one result
    public function campaignsStatistics()
    {
        $widgetShowGroup = TrackingShow::query()
            ->select(DB::raw('widget_id, count(*) as widget_show_count'))
            ->groupBy('widget_id');

        $directDonationsGroup = Donation::query()
            ->select(DB::raw('widget_id as widget_id_donation_group, count(*) as widget_direct_count, sum(donations.amount) as widget_direct_sum'))
            ->whereNotNull('payment_id')
            ->groupBy('widget_id');

        $referralDonationsGroup = Donation::query()
            ->select(DB::raw('referral_widget_id, count(*) as widget_referral_count, sum(donations.amount) as widget_referral_sum'))
            ->whereNotNull('payment_id')
            ->groupBy('referral_widget_id');

        $widgetQuery = Widget::query()->select('id as widget_id', 'campaign_id', 'widget_type_id');

        return Campaign::query()
            ->leftJoinSub($widgetQuery, 'widgetQuery', function ($join) {
                $join->on('campaigns.id', '=', 'widgetQuery.campaign_id');
            })
            ->leftJoinSub($widgetShowGroup, 'widgetShowGroup', function ($join) {
                $join->on('widgetQuery.widget_id', '=', 'widgetShowGroup.widget_id');
            })
            ->leftJoinSub($directDonationsGroup, 'directDonationsGroup', function ($join) {
                $join->on('widgetQuery.widget_id', '=', 'directDonationsGroup.widget_id_donation_group');
            })
            ->leftJoinSub($referralDonationsGroup, 'referralDonationsGroup', function ($join) {
                $join->on('widgetQuery.widget_id', '=', 'referralDonationsGroup.referral_widget_id');
            })
            ->join('campaign_promotes', 'campaigns.id', '=', 'campaign_promotes.campaign_id')
            ->with('promote')
            ->orderBy('campaigns.created_at', 'desc')
            ->get();
    }

    public function campaignStats($from, $to, $id, $total)
    {
        $widgetShowGroup = TrackingShow::query()
            ->select(DB::raw('widget_id, count(*) as widget_show_count'))
            ->groupBy('widget_id');

        $directDonationsGroup = Donation::query()
            ->select(DB::raw('widget_id, count(*) as widget_direct_count, sum(donations.amount) as widget_direct_sum'))
            ->whereNotNull('payment_id')
            ->groupBy('widget_id');

        $referralDonationsGroup = Donation::query()
            ->select(DB::raw('referral_widget_id, count(*) as widget_referral_count, sum(donations.amount) as widget_referral_sum'))
            ->whereNotNull('payment_id')
            ->groupBy('referral_widget_id');

        if ($total === false) {
            $widgetShowGroup
                ->whereDate('created_at', '>=', $from)
                ->whereDate('created_at', '<=', $to);
            $directDonationsGroup
                ->whereDate('created_at', '>=', $from)
                ->whereDate('created_at', '<=', $to);
            $referralDonationsGroup
                ->whereDate('created_at', '>=', $from)
                ->whereDate('created_at', '<=', $to);
        }
        $widgetQuery = Widget::query()
            ->select('id as widget_id', 'campaign_id', 'widget_type_id');

        return Campaign::query()
            ->where('id', $id)
            ->leftJoinSub($widgetQuery, 'widgetQuery', function ($join) {
                $join->on('campaigns.id', '=', 'widgetQuery.campaign_id');
            })
            ->leftJoinSub($widgetShowGroup, 'widgetShowGroup', function ($join) {
                $join->on('widgetQuery.widget_id', '=', 'widgetShowGroup.widget_id');
            })
            ->leftJoinSub($directDonationsGroup, 'directDonationsGroup', function ($join) {
                $join->on('widgetQuery.widget_id', '=', 'directDonationsGroup.widget_id');
            })
            ->leftJoinSub($referralDonationsGroup, 'referralDonationsGroup', function ($join) {
                $join->on('widgetQuery.widget_id', '=', 'referralDonationsGroup.referral_widget_id');
            })
            ->get();
    }
}