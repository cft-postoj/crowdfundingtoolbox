<?php

namespace Modules\Statistics\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Payment\Entities\Donation;
use Modules\UserManagement\Entities\PortalUser;

class StatsDonorRepository implements StatsDonorRepositoryInterface
{

    protected $model;

    // donations_sum
    private $donationsSum;

    // first donation and date for portal user, when he successfully made first donation monthly group
    private $firstDonationMonthly;

    // first donation and date for portal user, when he successfully made first donation
    private $firstDonation;

    function __construct()
    {
        $this->model = PortalUser::class;
        $this->donationsSum = Donation::query()
            ->select('portal_user_id', DB::raw('sum(amount) as amount_sum'),
                DB::raw('MIN(created_at) as first_donation_at'))
            ->groupBy('portal_user_id');

        $this->firstDonationMonthly = Donation::query()
            ->select('portal_user_id', 'is_monthly_donation',
                DB::raw('MIN(created_at) as first_donation_at'))
            ->groupBy('portal_user_id', 'is_monthly_donation');

        // first donation and date for portal user, when he successfully made first donation
        $this->firstDonation = Donation::query()
            ->select('portal_user_id',
                DB::raw('MIN(created_at) as first_donation_at'))
            ->groupBy('portal_user_id');
    }

    public function getDonors($from, $to, $monthly)
    {
        // get date of last donation
        $lastDonationAt = Donation::query()
            ->select('portal_user_id', DB::raw('MAX(created_at) as last_donation_at'))
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->groupBy('portal_user_id');

        //if monthly is set, filter lastDonationAt
        if ($monthly !== null) {
            $lastDonationAt = $lastDonationAt->where('is_monthly_donation', $monthly);
        }
        // last donation detail
        $lastDonation = Donation::query()
            ->select('portal_user_id', 'amount as last_donation_value', 'is_monthly_donation as last_donation_monthly',
                'payment_method as last_donation_payment_method', 'created_at');


        return PortalUser::query()
            ->joinSub($lastDonationAt, 'latest_donation_group', function ($join) use ($lastDonation, $from, $to) {
                $join->on('portal_users.id', '=', 'latest_donation_group.portal_user_id');
            })
            ->joinSub($lastDonation, 'latest_donation', function ($join) use ($from, $to) {
                $join->on('last_donation_at', '=', 'latest_donation.created_at');
            })
            ->joinSub($this->donationsSum, 'donations_sum', function ($join) {
                $join->on('portal_users.id', '=', 'donations_sum.portal_user_id');
            })
            ->orderBy('last_donation_at', 'DESC')
            ->with('user.userDetail')
            ->get();
    }

    public function countOfNewDonors($from, $to)
    {
        //get only those portal users who made first donation at specific time period
        return PortalUser::query()
            ->select(DB::raw('count(id)'), 'is_monthly_donation')
            ->joinSub($this->firstDonationMonthly, 'first_donation', function ($join) use ($from, $to) {
                $join->on('portal_users.id', '=', 'first_donation.portal_user_id');
            })
            ->whereDate('first_donation_at', '>=', $from)
            ->whereDate('first_donation_at', '<=', $to)
            ->groupBy('is_monthly_donation')
            ->get();
    }

    public function getDonorsNew($from, $to, $monthly)
    {
        // get date of last donation
        $lastDonationAt = Donation::query()
            ->select('portal_user_id', DB::raw('MAX(created_at) as last_donation_at'))
            ->groupBy('portal_user_id');

        // last donation detail
        $lastDonation = Donation::query()
            ->select('portal_user_id', 'amount as last_donation_value', 'is_monthly_donation as last_donation_monthly',
                'payment_method as last_donation_payment_method', 'created_at');

        // donations_sum
        $donationsSum = Donation::query()
            ->select('portal_user_id',
                DB::raw('sum(amount) as amount_sum'))
            ->groupBy('portal_user_id');

        // first donation and date for portal user, when he successfully made first donation
        $firstDonation = Donation::query()
            ->select('portal_user_id',
                DB::raw('MIN(created_at) as first_donation_at'))
            ->groupBy('portal_user_id');

        //if monthly is set, filter lastDonationAt
        if ($monthly !== null) {
            $firstDonation = $firstDonation->where('is_monthly_donation', $monthly);
        }

        return PortalUser::query()
            ->joinSub($lastDonationAt, 'latest_donation_group', function ($join) use ($lastDonation, $from, $to) {
                $join->on('portal_users.id', '=', 'latest_donation_group.portal_user_id');
            })
            ->joinSub($lastDonation, 'latest_donation', function ($join) use ($from, $to) {
                $join->on('last_donation_at', '=', 'latest_donation.created_at');
            })
            ->joinSub($donationsSum, 'donations_sum', function ($join) {
                $join->on('portal_users.id', '=', 'donations_sum.portal_user_id');
            })
            ->joinSub($firstDonation, 'first_donation', function ($join) {
                $join->on('portal_users.id', '=', 'first_donation.portal_user_id');
            })
            ->orderBy('last_donation_at', 'DESC')
            ->with('user.userDetail')
            ->whereDate('first_donation_at', '>=', $from)
            ->whereDate('first_donation_at', '<=', $to)
            ->get();
    }

    public function getDonorsStoppedSupporting($stopAfterDate, $limit)
    {
        // get date of last donation
        $lastMonthlyDonationAt = Donation::query()
            ->select('portal_user_id', DB::raw('MAX(created_at) as last_donation_at'))
            ->where('is_monthly_donation', true)
            ->groupBy('portal_user_id');

        // last donation detail
        $lastMonthlyDonation = Donation::query()
            ->select('portal_user_id', 'amount as last_donation_value', 'is_monthly_donation as last_donation_monthly',
                'payment_method as last_donation_payment_method', 'created_at');

        $resultQuery = PortalUser::query()
            ->joinSub($lastMonthlyDonationAt, 'latest_donation_group', function ($join) {
                $join->on('portal_users.id', '=', 'latest_donation_group.portal_user_id');
            })
            ->joinSub($lastMonthlyDonation, 'latest_donation', function ($join) {
                $join->on('last_donation_at', '=', 'latest_donation.created_at');
            })
            ->joinSub($this->donationsSum, 'donations_sum', function ($join) {
                $join->on('portal_users.id', '=', 'donations_sum.portal_user_id');
            })
            ->joinSub($this->firstDonation, 'first_donation', function ($join) {
                $join->on('portal_users.id', '=', 'first_donation.portal_user_id');
            })
            ->orderBy('last_donation_at', 'DESC')
            ->with('user.userDetail')
            ->whereDate('last_donation_at', '<=', $stopAfterDate);
        if ($limit !== null) {
            $resultQuery = $resultQuery->limit($limit);
        }
        return $resultQuery->get();
    }


    public function getDonorsStoppedSupportingCount($stopAfterDate)
    {
        // get date of last donation
        $lastMonthlyDonationAt = Donation::query()
            ->select('portal_user_id', DB::raw('MAX(created_at) as last_donation_at'))
            ->where('is_monthly_donation', true)
            ->groupBy('portal_user_id');

        // last donation detail
        $lastMonthlyDonation = Donation::query()
            ->select('portal_user_id', 'amount as last_donation_value', 'is_monthly_donation as last_donation_monthly',
                'payment_method as last_donation_payment_method', 'created_at');

        return PortalUser::query()
            ->joinSub($lastMonthlyDonationAt, 'latest_donation_group', function ($join) {
                $join->on('portal_users.id', '=', 'latest_donation_group.portal_user_id');
            })
            ->joinSub($lastMonthlyDonation, 'latest_donation', function ($join) {
                $join->on('last_donation_at', '=', 'latest_donation.created_at');
            })
            ->with('user')
            ->whereDate('last_donation_at', '<=', $stopAfterDate)->count();
    }

}