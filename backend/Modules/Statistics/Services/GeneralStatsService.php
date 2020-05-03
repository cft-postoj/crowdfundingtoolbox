<?php


namespace Modules\Statistics\Services;

use Carbon\Carbon;
use Modules\Statistics\Repositories\GeneralStatsRepository;

class GeneralStatsService
{
    protected $generalStatsRepository;

    public function __construct(GeneralStatsRepository $generalStatsRepository)
    {
        $this->generalStatsRepository = $generalStatsRepository;
    }

    public function articlesStatistics($request)
    {
        $valid = validator($request->only(
            'from',
            'to'
        ), [
            'from' => 'required|string',
            'to' => 'required|string'
        ]);

        if ($valid->fails()) {
            $jsonError = response()->json([
                'error' => $valid->errors()
            ], 400);
            return $jsonError;
        }
        try {
            $articles = $this->generalStatsRepository->articlesStatistics($request['from'], $request['to']);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], 400);
        }
        return $articles;
    }

    public function campaignsStatistics($request)
    {
        $valid = validator($request->only(
            'from',
            'to'
        ), [
            'from' => 'required|string',
            'to' => 'required|string'
        ]);

        if ($valid->fails()) {
            $jsonError = response()->json([
                'error' => $valid->errors()
            ], 400);
            return $jsonError;
        }

        $result = array();
        try {
            $widgets = $this->generalStatsRepository->campaignsStatistics();
            $campaigns = array();

            foreach ($widgets as $widget) {
                //find campaign in campaigns with same id as widget_id
                $campaignId = array_search($widget->campaign_id, array_column($campaigns, 'id'));
                if ($campaignId === false) {
                    array_push($campaigns, array(
                        'id' => $widget->campaign_id,
                        'visits' => 0,
                        'amount_direct_sum' => 0,
                        'amount_referral_sum' => 0,
                        'title' => $widget->name,
                        'created_at' => $widget->created_at,
                        'landing_page_visits' => 0,
                        'landing_page_amount' => 0,
                        'sidebar_visits' => 0,
                        'sidebar_amount' => 0,
                        'leaderboard_visits' => 0,
                        'leaderboard_amount' => 0,
                        'popup_visits' => 0,
                        'popup_amount' => 0,
                        'fixed_visits' => 0,
                        'fixed_amount' => 0,
                        'locked_visits' => 0,
                        'locked_amount' => 0,
                        'article_widget_visits' => 0,
                        'article_widget_amount' => 0,
                        'custom_visits' => 0,
                        'custom_amount' => 0));
                    $campaignId = array_search($widget->campaign_id, array_column($campaigns, 'id'));
                }
                $campaigns[$campaignId]['visits'] += $widget->widget_show_count;
                $campaigns[$campaignId]['amount_direct_sum'] += $widget->widget_direct_sum;
                $campaigns[$campaignId]['amount_referral_sum'] += $widget->widget_referral_sum;
                switch ($widget->widget_type_id) {
                    case 1: // landing page
                        $campaigns[$campaignId]['landing_page_visits'] = $widget->widget_show_count;
                        $campaigns[$campaignId]['landing_page_amount'] = $widget->widget_direct_sum + $widget->widget_referral_sum;
                        break;
                    case 2: // sidebar
                        $campaigns[$campaignId]['sidebar_visits'] = $widget->widget_show_count;
                        $campaigns[$campaignId]['sidebar_amount'] = $widget->widget_direct_sum + $widget->widget_referral_sum;
                        break;
                    case 3: // leaderboard
                        $campaigns[$campaignId]['leaderboard_visits'] = $widget->widget_show_count;
                        $campaigns[$campaignId]['leaderboard_amount'] = $widget->widget_direct_sum + $widget->widget_referral_sum;
                        break;
                    case 4: // popup
                        $campaigns[$campaignId]['popup_visits'] = $widget->widget_show_count;
                        $campaigns[$campaignId]['popup_amount'] = $widget->widget_direct_sum + $widget->widget_referral_sum;
                        break;
                    case 5: // fixed
                        $campaigns[$campaignId]['fixed_visits'] = $widget->widget_show_count;
                        $campaigns[$campaignId]['fixed_amount'] = $widget->widget_direct_sum + $widget->widget_referral_sum;
                        break;
                    case 6: // locked
                        $campaigns[$campaignId]['locked_visits'] = $widget->widget_show_count;
                        $campaigns[$campaignId]['locked_amount'] = $widget->widget_direct_sum + $widget->widget_referral_sum;
                        break;
                    case 7: // article widget
                        $campaigns[$campaignId]['article_widget_visits'] = $widget->widget_show_count;
                        $campaigns[$campaignId]['article_widget_amount'] = $widget->widget_direct_sum + $widget->widget_referral_sum;
                        break;
                    case 9: // custom widget
                        $campaigns[$campaignId]['custom_visits'] = $widget->widget_show_count;
                        $campaigns[$campaignId]['custom_amount'] = $widget->widget_direct_sum + $widget->widget_referral_sum;
                        break;
                }
            }

        } catch (\Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], 400);
        }
        return $campaigns;
    }

    public function getCampaignStatsById($period, $id)
    {

        try {
            $from = Carbon::createFromFormat('Y-m-d H:i:s', '2015-01-01 0:00:00');
            $to = Carbon::now();
            $total  = false;
            switch ($period) {
                case 'total':
                    $total  = true;
                    break;
                case 'year':
                    $from = Carbon::now()->subDays(365);
                    break;
                case 'month':
                    $from = Carbon::now()->subDays(30);
                    break;
                case 'week':
                    $from = Carbon::now()->subDays(7);
                    break;
                case 'day':
                    $from = Carbon::now()->subDays(1);
                    break;
            }
            $widgets = $this->generalStatsRepository->campaignStats($from, $to, $id, $total);

        } catch (\Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], 400);
        }
        return $widgets;
    }
}