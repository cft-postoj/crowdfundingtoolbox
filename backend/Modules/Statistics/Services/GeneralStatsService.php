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
}