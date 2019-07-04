<?php


namespace Modules\Targeting\Services;


use Carbon\Carbon;
use Illuminate\Http\Response;
use Modules\Payment\Services\DonationService;
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
        $countVisitors = 0;
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
                //$users = $this->portalUserService->getAll();
                $usersObject = $this->portalUserService->getAllWithDonations();
                $this->users = json_decode($usersObject->original);
                $this->countUsers = sizeof($this->users);

                foreach ($this->users as $user) {
                    $actualUserDonations = $user->donations;
                    $this->removeItemStatus = false;

                    // if is not supporter active
                    if ($not_supporter['active']) {
                        if ($actualUserDonations === null) {
                            $isUserInScope = true;
                            $this->removeUsersFromResult($user);
                        }
                    }

                    if ($actualUserDonations !== null) {
                        // if portal user has some only donations
                        if (!$one_time_supporter['active'] && !$monthly_supporter['active'] && !$not_supporter['active']) {
                            $isUserInScope = true;
                        } else {
                            if (!$this->removeItemStatus && $one_time_supporter['active'] && $this->donationService->isUserOneTimeSupporter($actualUserDonations)) {
                                $isUserInScope = true;
                                // One-time payment older/not older than...
                                if (!$this->removeItemStatus && ($one_time_supporter['older_than']['active'] || $one_time_supporter['not_older_than']['active'])) {
                                    if (!$this->donationService->isInSpecificLastPaymentTarget(
                                        $actualUserDonations,
                                        ($one_time_supporter['older_than']['active']) ?
                                            (($one_time_supporter['older_than']['value'] === null) ? 0 : $one_time_supporter['older_than']['value'])
                                            : null,
                                        ($one_time_supporter['not_older_than']['active']) ?
                                            (($one_time_supporter['not_older_than']['value'] === null) ? 0 : $one_time_supporter['not_older_than']['value'])
                                            : null,
                                        'one-time'
                                    )) {
                                        $this->removeUsersFromResult($user);
                                    }
                                }

                                // One-time donation is bigger/less than..
                                if (!$this->removeItemStatus && ($one_time_supporter['min']['active'] || $one_time_supporter['max']['active'])) {
                                    if (!$this->donationService->isInSpecificDonationTarget(
                                        $actualUserDonations,
                                        ($one_time_supporter['min']['active']) ?
                                            (($one_time_supporter['min']['value'] === null) ? 0 : $one_time_supporter['min']['value'])
                                            : null,
                                        ($one_time_supporter['max']['active']) ?
                                            (($one_time_supporter['max']['value'] === null) ? 0 : $one_time_supporter['max']['value'])
                                            : null,
                                        'one-time'
                                    )) {
                                        $this->removeUsersFromResult($user);
                                    }
                                }
                            } else if (!$this->removeItemStatus && $one_time_supporter['active'] && !$this->donationService->isUserOneTimeSupporter($actualUserDonations)) {
                                $isUserInScope = true;
                                $this->removeUsersFromResult($user);
                            }

                            // if portal user has some monthly donations
                            if (!$this->removeItemStatus && !$this->donationService->isUserOneTimeSupporter($actualUserDonations) && $monthly_supporter['active']) {
                                $isUserInScope = true;

                                // Monthly payment older/not older than...
                                if (!$this->removeItemStatus && ($monthly_supporter['older_than']['active'] || $monthly_supporter['not_older_than']['active'])) {
                                    if (!$this->donationService->isInSpecificLastPaymentTarget(
                                        $actualUserDonations,
                                        ($monthly_supporter['older_than']['active']) ?
                                            (($monthly_supporter['older_than']['value'] === null) ? 0 : $monthly_supporter['older_than']['value'])
                                            : null,
                                        ($monthly_supporter['not_older_than']['active']) ?
                                            (($monthly_supporter['not_older_than']['value'] === null) ? 0 : $monthly_supporter['not_older_than']['value'])
                                            : null,
                                        'monthly'
                                    )) {
                                        $this->removeUsersFromResult($user);
                                    }
                                }

                                // Monthly donation is bigger/less than..
                                if (!$this->removeItemStatus && ($monthly_supporter['min']['active'] || $monthly_supporter['max']['active'])) {
                                    if (!$this->donationService->isInSpecificDonationTarget(
                                        $actualUserDonations,
                                        ($monthly_supporter['min']['active']) ?
                                            (($monthly_supporter['min']['value'] === null) ? 0 : $monthly_supporter['min']['value'])
                                            : null,
                                        ($monthly_supporter['max']['active']) ?
                                            (($monthly_supporter['max']['value'] === null) ? 0 : $monthly_supporter['max']['value'])
                                            : null,
                                        'monthly'
                                    )) {
                                        $this->removeUsersFromResult($user);
                                    }
                                }
                            }

                            if (!$this->removeItemStatus && $not_supporter['active'] && !$monthly_supporter['active'] && !$one_time_supporter['active']) {
                                $isUserInScope = true;
                                $this->removeUsersFromResult($user);
                            }
                        }
                    }


                    // COUNT OF READ ARTICLES
                    if (!$this->removeItemStatus && ($readArticles['today']['active'] || $readArticles['week']['active'] || $readArticles['month']['active'])) {
                        $isUserInScope = true;
                        $today = ($readArticles['today']['active']) ?
                            $this->trackingService->hasUserReadArticles($user->visit, 'today', $readArticles['today']['min'], $readArticles['today']['max']) : null;
                        $week = ($readArticles['week']['active']) ?
                            $this->trackingService->hasUserReadArticles($user->visit, 'week', $readArticles['week']['min'], $readArticles['week']['max']) : null;
                        $month = ($readArticles['month']['active']) ?
                            $this->trackingService->hasUserReadArticles($user->visit, 'month', $readArticles['month']['min'], $readArticles['month']['max']) : null;


                        if (!$this->isReadArticle($today, $week, $month)) {
                            $this->removeUsersFromResult($user);
                        }

                    }

                    // USER REGISTRATION BEFORE / AFTER
                    if (!$this->removeItemStatus && ($registrationBefore['active'] || $registrationAfter['active'])) {
                        $isUserInScope = true;
                        if ($registrationBefore['active']) {
                            $year = $registrationBefore['date']['year'];
                            $month = $num_padded = sprintf("%02d", $registrationBefore['date']['month']);
                            $day = $num_padded = sprintf("%02d", $registrationBefore['date']['day']);
                            $choosedRegistrationdate = Carbon::createFromFormat('Y-m-d H:i:s', $year . '-' . $month . '-' . $day . ' 23:59:59');
                            $userRegistrationDate = Carbon::createFromFormat('Y-m-d H:i:s', $user->created_at);
                            if ($userRegistrationDate >= $choosedRegistrationdate) {
                                $this->removeUsersFromResult($user);
                            }
                        }
                        if (!$this->removeItemStatus && $registrationAfter['active']) {
                            $year = $registrationAfter['date']['year'];
                            $month = $num_padded = sprintf("%02d", $registrationAfter['date']['month']);
                            $day = $num_padded = sprintf("%02d", $registrationAfter['date']['day']);
                            $choosedRegistrationdate = Carbon::createFromFormat('Y-m-d H:i:s', $year . '-' . $month . '-' . $day . ' 23:59:59');
                            $userRegistrationDate = Carbon::createFromFormat('Y-m-d H:i:s', $user->created_at);
                            if ($userRegistrationDate <= $choosedRegistrationdate) {
                                $this->removeUsersFromResult($user);
                            }
                        }
                    }


                    if (!$isUserInScope) {
                        $this->removeUsersFromResult($user);
                    }

                    $isUserInScope = false;

                    if (!$this->removeItemStatus) {
                        array_push($usersList, array(
                            'email' => $user->user->email,
                            'first_name' => $user->user->user_detail->first_name,
                            'last_name' => $user->user->user_detail->last_name,
                            'id' => $user->user_id
                        ));
                    }

                }
            }

            if ($notsigned_status) {
                $countVisitors = 999999;
            }

        } catch (\Exception $exception) {
            response()->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        return \response()->json([
            'count_users' => $this->countUsers,
            'count_visitors' => $countVisitors,
            'users' => $usersList
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