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
        $result = array();
        try {
            $articles = $this->generalStatsRepository->articlesStatistics($request['from'], $request['to']);
            //return $articles;
            $ids = array();
            foreach ($articles as $article) {
                if (!in_array($article->article_id, $ids)) {
                    array_push($ids, $article->article_id);
                    $visits = 0;
                    $amount = 0;
                    $users = 0;
                    foreach ($articles as $a) {
                        if ($a->article_id === $article->article_id) {
                            foreach ($a->show as $s) {
                                if ($s->donation !== null) {
                                    if ($s->donation->payment_id !== null) {
                                        $amount += $s->donation->amount;
                                    }
                                    // if donation (without payment_id too) is first donation and registered action
                                    if ($a->portalUser !== null) {
                                        if (abs(Carbon::createFromFormat('Y-m-d H:i:s', $a->portalUser->created_at)->diffInMinutes() - Carbon::createFromFormat('Y-m-d H:i:s', $s->donation->created_at)->diffInMinutes()) < 5) {
                                            $users++;
                                        }
                                    }


                                }
                            }
                            $visits++;
                        }
                    }
                    $row = array(
                        'title' => $article->title,
                        'url' => $article->url,
                        'visits' => $visits,
                        'amount' => $amount,
                        'users' => $users
                    );
                    array_push($result, $row);
                }
            }
        } catch (\Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], 400);
        }
        return $result;
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
            $campaigns = $this->generalStatsRepository->campaignsStatistics($request['from'], $request['to']);
            $ids = array();
            foreach ($campaigns as $campaign) {
                $amount_sum = 0;
                $visits = 0;
                $langing_page_visit = 0;
                $langing_page_amount = 0;
                $sidebar_visit = 0;
                $sidebar_amount = 0;
                $leaderboard_visit = 0;
                $leaderboard_amount = 0;
                $popup_visit = 0;
                $popup_amount = 0;
                $fixed_visit = 0;
                $fixed_amount = 0;
                $locked_visit = 0;
                $locked_amount = 0;
                $article_widget_visit = 0;
                $article_widget_amount = 0;
                $custom_visit = 0;
                $custom_amount = 0;

                foreach ($campaign->widget as $w) {
                    $visits += sizeof($w->show);
                    switch ($w->widget_type_id) {
                        case 1: // landing page
                            $langing_page_visit = sizeof($w->show);
                            break;
                        case 2: // sidebar
                            $sidebar_visit = sizeof($w->show);
                            break;
                        case 3: // leaderboard
                            $leaderboard_visit = sizeof($w->show);
                            break;
                        case 4: // popup
                            $popup_visit = sizeof($w->show);
                            break;
                        case 5: // fixed
                            $fixed_visit = sizeof($w->show);
                            break;
                        case 6: // locked
                            $locked_visit = sizeof($w->show);
                            break;
                        case 7: // article widget
                            $article_widget_visit = sizeof($w->show);
                            break;
                        case 9: // custom widget
                            $custom_visit = sizeof($w->show);
                            break;
                    }
                    if ($w->donation != null) {
                        foreach ($w->donation as $don) {
                            if ($don->payment_id !== null) {
                                $amount_sum += $don->amount;
                                switch ($w->widget_type_id) {
                                    case 1: // landing page
                                        $langing_page_amount += $don->amount;
                                        break;
                                    case 2: // sidebar
                                        $sidebar_amount += $don->amount;
                                        break;
                                    case 3: // leaderboard
                                        $leaderboard_amount += $don->amount;
                                        break;
                                    case 4: // popup
                                        $popup_amount += $don->amount;
                                        break;
                                    case 5: // fixed
                                        $fixed_amount += $don->amount;
                                        break;
                                    case 6: // locked
                                        $locked_amount += $don->amount;
                                        break;
                                    case 7: // article widget
                                        $article_widget_amount += $don->amount;
                                        break;
                                    case 9: // custom widget
                                        $custom_amount += $don->amount;
                                        break;
                                }
                            }
                        }
                    }

                }
                $row = array(
                    'id' => $campaign->id,
                    'title' => $campaign->name,
                    'created_at' => $campaign->created_at,
                    'visits' => $visits,
                    'amount' => $amount_sum,
                    'landing_page' => array(
                        'visit' => $langing_page_visit,
                        'amount' => $langing_page_amount
                    ), 'leaderboard' => array(
                        'visit' => $leaderboard_visit,
                        'amount' => $leaderboard_amount
                    ), 'sidebar' => array(
                        'visit' => $sidebar_visit,
                        'amount' => $sidebar_amount
                    ), 'article_widget' => array(
                        'visit' => $article_widget_visit,
                        'amount' => $article_widget_amount
                    ), 'locked_article' => array(
                        'visit' => $locked_visit,
                        'amount' => $locked_amount
                    ), 'popup' => array(
                        'visit' => $popup_visit,
                        'amount' => $popup_amount
                    ), 'fixed' => array(
                        'visit' => $fixed_visit,
                        'amount' => $fixed_amount
                    ), 'custom' => array(
                        'visit' => $custom_visit,
                        'amount' => $custom_amount
                    )
                );
                array_push($result, $row);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], 400);
        }
        return $result;
    }

    public function getCampaignStatsById($period, $id)
    {

        try {
            $from = Carbon::createFromFormat('Y-m-d H:i:s', '2015-01-01 0:00:00');
            $to = Carbon::now();

            $amount_sum = 0;
            $visits = 0;
            $donation_count = 0;
            $langing_page_visit = 0;
            $langing_page_amount = 0;
            $landing_page_donation_count = 0;
            $sidebar_visit = 0;
            $sidebar_amount = 0;
            $sidebar_donation_count = 0;
            $leaderboard_visit = 0;
            $leaderboard_amount = 0;
            $leaderboard_donation_count = 0;
            $popup_visit = 0;
            $popup_amount = 0;
            $popup_donation_count = 0;
            $fixed_visit = 0;
            $fixed_amount = 0;
            $fixed_donation_count = 0;
            $locked_visit = 0;
            $locked_amount = 0;
            $locked_donation_count = 0;
            $article_widget_visit = 0;
            $article_widget_amount = 0;
            $article_widget_donation_count = 0;
            $custom_visit = 0;
            $custom_amount = 0;
            $custom_donation_count = 0;

            switch ($period) {
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

            $campaign = $this->generalStatsRepository->campaignStats($from, $to, $id);
            if ($campaign !== null){
                foreach ($campaign->widget as $w) {
                    $visits += sizeof($w->show);
                    switch ($w->widget_type_id) {
                        case 1: // landing page
                            $langing_page_visit = sizeof($w->show);
                            break;
                        case 2: // sidebar
                            $sidebar_visit = sizeof($w->show);
                            break;
                        case 3: // leaderboard
                            $leaderboard_visit = sizeof($w->show);
                            break;
                        case 4: // popup
                            $popup_visit = sizeof($w->show);
                            break;
                        case 5: // fixed
                            $fixed_visit = sizeof($w->show);
                            break;
                        case 6: // locked
                            $locked_visit = sizeof($w->show);
                            break;
                        case 7: // article widget
                            $article_widget_visit = sizeof($w->show);
                            break;
                        case 9: // custom widget
                            $custom_visit = sizeof($w->show);
                            break;
                    }

                    if ($w->donation != null) {
                        foreach ($w->donation as $don) {
                            if ($don->payment_id !== null) {
                                $donation_count++;
                                $amount_sum += $don->amount;
                                switch ($w->widget_type_id) {
                                    case 1: // landing page
                                        $langing_page_amount += $don->amount;
                                        $landing_page_donation_count++;
                                        break;
                                    case 2: // sidebar
                                        $sidebar_amount += $don->amount;
                                        $sidebar_donation_count++;
                                        break;
                                    case 3: // leaderboard
                                        $leaderboard_amount += $don->amount;
                                        $leaderboard_donation_count++;
                                        break;
                                    case 4: // popup
                                        $popup_amount += $don->amount;
                                        $popup_donation_count++;
                                        break;
                                    case 5: // fixed
                                        $fixed_amount += $don->amount;
                                        $fixed_donation_count++;
                                        break;
                                    case 6: // locked
                                        $locked_amount += $don->amount;
                                        $locked_donation_count++;
                                        break;
                                    case 7: // article widget
                                        $article_widget_amount += $don->amount;
                                        $article_widget_donation_count++;
                                        break;
                                    case 9: // custom widget
                                        $custom_amount += $don->amount;
                                        $custom_donation_count++;
                                        break;
                                }
                            }
                        }
                    }
                }
            }

            $result = array(
              'amount_sum' => $amount_sum,
              'visits' => $visits,
              'engagement' => ($visits == 0) ? 0 : number_format((float)($donation_count / $visits * 100), 2, ',', ' '),
                'landing_page' => array(
                    'amount' => $langing_page_amount,
                    'visits' => $langing_page_visit,
                    'donations_count' => $landing_page_donation_count,
                    'engagement' => ($langing_page_visit == 0) ? 0 : number_format((float)($landing_page_donation_count / $langing_page_visit * 100), 2, ',', ' ')
                ), 'sidebar' => array(
                    'amount' => $sidebar_amount,
                    'visits' => $sidebar_visit,
                    'donations_count' => $sidebar_donation_count,
                    'engagement' => ($sidebar_visit == 0) ? 0 : number_format((float)($sidebar_donation_count / $sidebar_visit * 100), 2, ',', ' ')
                ), 'leaderboard' => array(
                    'amount' => $leaderboard_amount,
                    'visits' => $leaderboard_visit,
                    'donations_count' => $leaderboard_donation_count,
                    'engagement' => ($leaderboard_visit == 0) ? 0 : number_format((float)($leaderboard_donation_count / $leaderboard_visit * 100), 2, ',', ' ')
                ), 'popup' => array(
                    'amount' => $popup_amount,
                    'visits' => $popup_visit,
                    'donations_count' => $popup_donation_count,
                    'engagement' => ($popup_visit == 0) ? 0 : number_format((float)($popup_donation_count / $popup_visit * 100), 2, ',', ' ')
                ), 'fixed' => array(
                    'amount' => $fixed_amount,
                    'visits' => $fixed_visit,
                    'donations_count' => $fixed_donation_count,
                    'engagement' => ($fixed_visit == 0) ? 0 : number_format((float)($fixed_donation_count / $fixed_visit * 100), 2, ',', ' ')
                ), 'locked' => array(
                    'amount' => $locked_amount,
                    'visits' => $locked_visit,
                    'donations_count' => $locked_donation_count,
                    'engagement' => ($locked_visit == 0) ? 0 : number_format((float)($locked_donation_count / $locked_visit * 100), 2, ',', ' ')
                ), 'article_widget' => array(
                    'amount' => $article_widget_amount,
                    'visits' => $article_widget_visit,
                    'donations_count' => $article_widget_donation_count,
                    'engagement' => ($article_widget_visit == 0) ? 0 : number_format((float)($article_widget_donation_count / $article_widget_visit * 100), 2, ',', ' ')
                ), 'custom' => array(
                    'amount' => $custom_amount,
                    'visits' => $custom_visit,
                    'donations_count' => $custom_donation_count,
                    'engagement' => ($custom_visit == 0) ? 0 : number_format((float)($custom_donation_count / $custom_visit * 100), 2, ',', ' ')
                )
            );

        } catch (\Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], 400);
        }
        return $result;
    }
}