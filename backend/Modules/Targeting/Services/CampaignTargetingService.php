<?php


namespace Modules\Targeting\Services;


use Carbon\Carbon;
use Illuminate\Http\Response;
use Modules\Payment\Services\DonationService;
use Modules\Targeting\Entities\AggregateTargeting;
use Modules\UserManagement\Services\PortalUserService;
use Modules\UserManagement\Services\TrackingService;

class CampaignTargetingService implements CampaignTargetingServiceInterface
{
    private $portalUserService;
    private $donationService;
    private $countUsers;
    private $users;
    private $removeItemStatus;
    private $trackingService;

    public function __construct(PortalUserService $portalUserService, DonationService $donationService, TrackingService $trackingService)
    {
        $this->portalUserService = $portalUserService;
        $this->donationService = $donationService;
        $this->countUsers = 0;
        $this->users = [];
        $this->removeItemStatus = false;
        $this->trackingService = $trackingService;
    }

    public function getUsersCount($request)
    {
        $usersList = [];
        $aggData = 0;
        $countVisitors = 999999;
        $isUserInScope = false;
        try {
            $signed_status = $request['signed_status']['signed']['active'];
            $notsigned_status = $request['signed_status']['not_signed']['active'];
            $one_time_supporter = $request['support']['one_time'];
            $monthly_supporter = $request['support']['monthly'];
            $not_supporter = $request['support']['not_supporter'];
            $readArticles = $request['read_articles'];
            $registrationBefore = $request['registration']['before'];
            $registrationAfter = $request['registration']['after'];


            if ($signed_status) {
                $whereClausules = array();
                $oneTimeDonationBefore = null;
                $oneTimeDonationAfter = null;
                $monthlyDonationBefore = null;
                $monthlyDonationAfter = null;

                if (!$notsigned_status) {
                    $countVisitors = 0;
                }

                $newArray = array();
                foreach($whereClausules as $array) {
                    foreach($array as $k=>$v) {
                        $newArray[$k] = $v;
                    }
                }

                // if is active one time supporter and monthly supporter in same time
                if ($one_time_supporter['active'] && $monthly_supporter['active']) {
                    if ($not_supporter['active']) {

                            $aggData = 'all';

                    } else {
                        $aggData = AggregateTargeting::where($newArray)
                            ->whereNotNull('last_donation_value')
                            ->where('last_donation_value', '>', 0);
                        $aggData->where(function ($q2) use ($one_time_supporter, $monthly_supporter) {
                            $q2->orWhere(function ($q3) use ($one_time_supporter) {
                                $q3->where('monthly_supporter', false);
                                if ($one_time_supporter['older_than']['active']) {
                                    $q3->where('last_donation_before', '>=', $one_time_supporter['older_than']['value']);
                                }
                                if ($one_time_supporter['not_older_than']['active']) {
                                    $q3->where('last_donation_before', '<=', $one_time_supporter['not_older_than']['value']);
                                }
                                if ($one_time_supporter['min']['active']) {
                                    $q3->where('last_donation_value', '>=', $one_time_supporter['min']['value']);
                                }
                                if ($one_time_supporter['max']['active']) {
                                    $q3->where('last_donation_value', '<=', $one_time_supporter['max']['value']);
                                }
                            });
                            $q2->orWhere(function ($q4) use ($monthly_supporter) {
                                $q4->where('monthly_supporter', true);
                                if ($monthly_supporter['older_than']['active']) {
                                    $q4->where('last_donation_before', '>=', $monthly_supporter['older_than']['value']);
                                }
                                if ($monthly_supporter['not_older_than']['active']) {
                                    $q4->where('last_donation_before', '<=', $monthly_supporter['not_older_than']['value']);
                                }
                                if ($monthly_supporter['min']['active']) {
                                    $q4->where('last_donation_value', '>=', $monthly_supporter['min']['value']);
                                }
                                if ($monthly_supporter['max']['active']) {
                                    $q4->where('last_donation_value', '<=', $monthly_supporter['max']['value']);
                                }
                            });
                        });

                    }

                } else if ($one_time_supporter['active'] !== $monthly_supporter['active']) {
                    if ($one_time_supporter['active']) {
                        $aggData = AggregateTargeting::whereNotNull('last_donation_value')
                            ->where('monthly_supporter', false);
                        $aggData->where(function ($q2) use ($one_time_supporter) {
                                if ($one_time_supporter['older_than']['active']) {
                                    $q2->where('last_donation_before', '>=', $one_time_supporter['older_than']['value']);
                                }
                                if ($one_time_supporter['not_older_than']['active']) {
                                    $q2->where('last_donation_before', '<=', $one_time_supporter['not_older_than']['value']);
                                }
                                if ($one_time_supporter['min']['active']) {
                                    $q2->where('last_donation_value', '>=', $one_time_supporter['min']['value']);
                                }
                                if ($one_time_supporter['max']['active']) {
                                    $q2->where('last_donation_value', '<=', $one_time_supporter['max']['value']);
                                }
                            });
                    } else {
                            $aggData = AggregateTargeting::whereNotNull('last_donation_value')
                                ->where('monthly_supporter', true);
                            $aggData->where(function ($q2) use ($monthly_supporter) {
                                if ($monthly_supporter['older_than']['active']) {
                                    $q2->where('last_donation_before', '>=', $monthly_supporter['older_than']['value']);
                                }
                                if ($monthly_supporter['not_older_than']['active']) {
                                    $q2->where('last_donation_before', '<=', $monthly_supporter['not_older_than']['value']);
                                }
                                if ($monthly_supporter['min']['active']) {
                                    $q2->where('last_donation_value', '>=', $monthly_supporter['min']['value']);
                                }
                                if ($monthly_supporter['max']['active']) {
                                    $q2->where('last_donation_value', '<=', $monthly_supporter['max']['value']);
                                }
                            });
                    }


                    if ($not_supporter['active']) {
                        $aggData = 'all';
                    } else {
                        if ($one_time_supporter['active']) {
                            if ($one_time_supporter['older_than']['active']) {
                                $aggData = $aggData->where('last_donation_before', '<=', $one_time_supporter['older_than']['value']);
                            }
                            if ($one_time_supporter['not_older_than']['active']) {
                                $aggData = $aggData->where('last_donation_before', '<=', $one_time_supporter['not_older_than']['value']);
                            }
                            if ($one_time_supporter['min']['active']) {
                                $aggData = $aggData->where('last_donation_value', '>=', $one_time_supporter['min']['value']);
                            }
                            if ($one_time_supporter['max']['active']) {
                                $aggData = $aggData->where('last_donation_value', '<=', $one_time_supporter['max']['value']);
                            }
                        }
                        if ($monthly_supporter['active']) {
                            if ($monthly_supporter['older_than']['active']) {
                                $aggData = $aggData->where('last_donation_before', '<=', $monthly_supporter['older_than']['value']);
                            }
                            if ($monthly_supporter['not_older_than']['active']) {
                                $aggData = $aggData->where('last_donation_before', '<=', $monthly_supporter['not_older_than']['value']);
                            }
                            if ($monthly_supporter['min']['active']) {
                                $aggData = $aggData->where('last_donation_value', '>=', $monthly_supporter['min']['value']);
                            }
                            if ($monthly_supporter['max']['active']) {
                                $aggData = $aggData->where('last_donation_value', '<=', $monthly_supporter['max']['value']);
                            }
                        }
                    }
                } else {
                    if ($not_supporter['active']) {
                        if (!$one_time_supporter['active'] && !$monthly_supporter['active']) {
                            $aggData = AggregateTargeting::where('last_donation_value', null);
                        }
                    } else {
                        $aggData = AggregateTargeting::where($newArray);
                    }

                }

                if ($aggData === 'all') {
                    $aggData = AggregateTargeting::where('id', '>=', 1);
                }


                // READ ARTICLES
                if ($readArticles['today']['active']) {
                    $aggData = $aggData->where('read_articles_today', '>=', $readArticles['today']['min']);
                    $aggData = $aggData->where('read_articles_today', '<=', $readArticles['today']['max']);
                }
                if ($readArticles['week']['active']) {
                    $aggData = $aggData->where('read_articles_week', '>=', $readArticles['week']['min']);
                    $aggData = $aggData->where('read_articles_week', '<=', $readArticles['week']['max']);
                }
                if ($readArticles['month']['active']) {
                    $aggData = $aggData->where('read_articles_month', '>=', $readArticles['month']['min']);
                    $aggData = $aggData->where('read_articles_month', '<=', $readArticles['month']['max']);
                }


                // REGISTRATION BEFORE/AFTER
                if ($registrationBefore['active']) {
                    $aggData = $aggData->whereDate('unlocked_at', '<=', Carbon::createFromFormat('Y-m-d', $registrationBefore['value']));
                }
                if ($registrationAfter['active']) {
                    $aggData = $aggData->whereDate('unlocked_at', '>=', Carbon::createFromFormat('Y-m-d', $registrationAfter['value']));
                }


                // VALID ADDRESS
                $aggData->where(function ($add) use ($request) {
                    if ($request['signed_status']['signed']['valid_address']) {
                        $add->orWhere('has_valid_address', true);
                    }
                    if ($request['signed_status']['signed']['not_valid_address']) {
                        $add->orWhere('has_valid_address', false);
                    }
                });


                $aggData = $aggData->get();
                $this->users = json_decode($aggData);
                $this->countUsers = count($this->users);

            }

        } catch (\Exception $exception) {
            response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        return \response()->json([
            'count_users' => $this->countUsers,
            'count_visitors' => $countVisitors,
            'users' => $aggData
        ], Response::HTTP_OK);
    }

    private function isReadArticle($today, $week, $month)
    {
        return ((!is_null($today)) ? $today : true) &&
            ((!is_null($week)) ? $week : true) &&
            ((!is_null($month)) ? $month : true);
    }

    private function removeUsersFromResult($actualUser)
    {
        $this->countUsers--;
        array_splice($this->users, array_search($actualUser, $this->users));
        $this->removeItemStatus = true;
    }
}