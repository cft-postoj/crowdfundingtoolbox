<?php

namespace Modules\Campaigns\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Campaigns\Entities\Campaign;
use Modules\Campaigns\Entities\CampaignVersion;
use Modules\Campaigns\Entities\UserData;
use Modules\Campaigns\Entities\Widget;
use Modules\Campaigns\Providers\CampaignPromoteRepository;
use Modules\Payment\Entities\Donation;
use Modules\Targeting\Providers\TargetingRepository;
use Modules\UserManagement\Entities\TrackingShow;
use Modules\UserManagement\Http\Controllers\UserRepositoryController;
use function foo\func;

class CampaignRepository implements CampaignRepositoryInterface
{

    /**
     * @param $rawCampaignData
     * @return Campaign
     */
    public function create($rawCampaignData): Campaign
    {
        $campaign = Campaign::create([
            'name' => $rawCampaignData['name'],
            'description' => $rawCampaignData['description'],
            'active' => $rawCampaignData['active']
        ]);
        return $campaign;
    }

    public function get($id)
    {
        return Campaign::with('targeting.urls')->with('promote')->with('targeting.excludedUrls')->find($id);
    }

    public function getAll()
    {
        //get number of widgets show of campaign as widget_show_count
        $widgetShowGroup = TrackingShow::query()
            ->select(DB::raw('widget_id as widget_show_id, count(*) as widget_show_count'))
            ->groupBy('widget_id');
        $campaignShowCount = Widget::query()
            ->select(DB::raw('campaign_id as campaign_show_id, sum(widget_show_count) as campaign_show_count'))
            ->leftJoinSub($widgetShowGroup, 'widget_show_group', function ($join) {
                $join->on('widgets.id', '=', 'widget_show_group.widget_show_id');
            })
            ->groupBy('campaign_id');


        $directDonationsAmount = Donation::query()
            ->select(DB::raw('widget_id as widget_id_direct_donations_amount,
                                    referral_widget_id  as widget_id_referral_donations_amount,
                                    amount as donation_amount'))
            ->whereNotNull('payment_id');

        $campaignDonationsDirectAmount = Widget::query()
            ->select('campaign_id', DB::raw('sum("directDonationsAmount"."donation_amount") as donation_direct_sum'))
            ->leftJoinSub($directDonationsAmount, 'directDonationsAmount', function ($join) {
                $join->on('widgets.id', '=', 'directDonationsAmount.widget_id_direct_donations_amount');
            })
            ->groupBy('campaign_id');

        $campaignDonationsReferralAmount = Widget::query()
            ->select('campaign_id', DB::raw('sum("directDonationsAmount"."donation_amount") as donation_referral_sum'))
            ->leftJoinSub($directDonationsAmount, 'directDonationsAmount', function ($join) {
                $join->on('widgets.id', '=', 'directDonationsAmount.widget_id_referral_donations_amount');
            })
            ->groupBy('campaign_id');

        return Campaign::query()
            ->leftJoinSub($campaignShowCount, 'campaign_show_count_group', function ($join) {
                $join->on('campaigns.id', '=', 'campaign_show_count_group.campaign_show_id');
            })
            ->leftJoinSub($campaignDonationsDirectAmount, 'campaignDonationsDirectAmount', function ($join) {
                $join->on('campaigns.id', '=', 'campaignDonationsDirectAmount.campaign_id');
            })
            ->leftJoinSub($campaignDonationsReferralAmount, 'campaignDonationsReferralAmount', function ($join) {
                $join->on('campaigns.id', '=', 'campaignDonationsReferralAmount.campaign_id');
            })
            ->with('targeting')
            ->with('promote')
            ->orderBy('active', 'desc')
            ->orderBy('updated_at', 'desc')
            ->get();


//        ->leftJoinSub($directDonationsGroup, 'directDonationsGroup', function ($join) {
//                $join->on('widgetQuery.widget_id', '=', 'directDonationsGroup.campaign_id_donation_group');
//
        //           })

        //            ->withCount('shows as widget_shows')

    }

    /**
     * @param $rawCampaignData
     * @return Campaign
     */
    public function update($rawCampaignData): Campaign
    {
        $campaign = $this->get($rawCampaignData['id']);

        $campaign->update([
            'name' => $rawCampaignData['name'],
            'description' => $rawCampaignData['description'],
            'active' => $rawCampaignData['active'],
            'priority' => $rawCampaignData['priority'],
        ]);
        return $campaign;
    }


    public function addTracking($campaignId, $userId, $data)
    {
        $campaignVersion = CampaignVersion::create([
            'campaign_id' => $campaignId,
            'user_id' => $userId,
            'campaign_data' => json_encode($data)
        ]);
        return $campaignVersion;
    }

    public function getActiveCampaigns(UserData $userData, $url, $author, $category)
    {
        $actualDate = date('Y-m-d');
        $campaignQuery = Campaign::query()
            ->whereHas('promote', function ($query) use ($actualDate, $url) {
                $query->where('end_date_value', '>=', $actualDate)
                    ->orWhere('is_end_date', false);
            })
            ->whereHas('targeting', function ($query) use ($userData, $url, $author, $category) {
                // handle specific url
                $query->where(function ($query) use ($url) {
                    // case where url_specific is false, or is true and ahas some binded urls
                    $query->where('url_specific', false)
                        ->orWhereHas('urls', function ($query) use ($url) {
                            $query->whereRaw("? like '%' || path || '%'", [$url]);
                        });
                })
                    // handle excluded urls
                    ->where(function ($query) use ($url) {
                        // case where url_specific is false, or is true and ahas some binded urls
                        $query->where('exclude_url_specific', false)
                            ->orWhereDoesntHave('excludedUrls', function ($query) use ($url) {
                                $query->whereRaw("? like '%' || path || '%'", [$url]);
                            });
                    })
                    //handle read articles
                    //handle today read articles
                    ->where(function ($query) use ($userData) {
                        //is deactivated
                        $query->where('read_articles_today', false)
                            // or is activated and user is in correct range
                            ->orWhere(function ($q2) use ($userData) {
                                $q2->where('read_articles_today_min', '<=', $userData->numberOfReadArticles['today'])
                                    ->where('read_articles_today_max', '>=', $userData->numberOfReadArticles['today']);
                            });
                    })
                    //handle read articles in week
                    ->where(function ($query) use ($userData) {
                        //is deactivated
                        $query->where('read_articles_week', false)
                            // or is activated and user is in correct range
                            ->orWhere(function ($q2) use ($userData) {
                                $q2->where('read_articles_week_min', '<=', $userData->numberOfReadArticles['week'])
                                    ->where('read_articles_week_max', '>=', $userData->numberOfReadArticles['week']);
                            });
                    })
                    //handle read articles in month
                    ->where(function ($query) use ($userData) {
                        //is deactivated
                        $query->where('read_articles_month', false)
                            // or is activated and user is in correct range
                            ->orWhere(function ($q2) use ($userData) {
                                $q2->where('read_articles_month_min', '<=', $userData->numberOfReadArticles['month'])
                                    ->where('read_articles_month_max', '>=', $userData->numberOfReadArticles['month']);
                            });
                    })
                    //handle authors
                    ->where(function ($query) use ($author) {
                        if ($author !== null) {
                            $query->where('author_specific', false)
                                ->orWhereHas('authors', function ($query) use ($author) {
                                    $query->whereRaw("? like '%' || author || '%'", $author);
                                });
                        }
                    })
                    //handle categories
                    ->where(function ($query) use ($category) {
                        if ($category !== null) {
                            $query->where('category_specific', false)
                                ->orWhereHas('categories', function ($query) use ($category) {
                                    $query->whereRaw("? like '%' || category || '%'", [$category]);
                                });
                        }
                    });
            })
            ->with('targeting')
            ->where('active', true);
        if ($userData->signed) {
            $campaignQuery = $campaignQuery
                ->whereHas('targeting', function ($query) use ($userData) {
                    $query->where('signed', true);
                    // valid / not valid delivery address
                    if ($userData->getValidAddress()) {
                        $query->where('valid_address', true);
                    } else {
                        $query->where('not_valid_address', true);
                    }
                });
        } else {
            $campaignQuery = $campaignQuery
                ->whereHas('targeting', function ($query) {
                    $query->where('not_signed', true);
                });
        }
        return $campaignQuery->orderBy('priority')->get();
    }
}