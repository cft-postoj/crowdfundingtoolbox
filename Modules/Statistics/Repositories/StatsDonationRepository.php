<?php

namespace Modules\Statistics\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Payment\Entities\Donation;

class StatsDonationRepository implements StatsDonationRepositoryInterface
{

    protected $model;

    function __construct()
    {
        $this->model = Donation::class;
    }

    public function getDonationsGroupIsMonthly($from, $to, $interval, $isMonthly)
    {
        return $this->model::select(
            DB::raw("date_trunc('$interval', created_at) AS date"), DB::raw('sum(donation) as value'))
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->where('is_monthly_donation', $isMonthly)
            ->groupBy(DB::raw('date'))
            ->get();
    }

    public function getDonorsGroupIsMonthly($from, $to, $interval, $isMonthly)
    {
        return $this->model::select(
            DB::raw("date_trunc('$interval', created_at) AS date"), DB::raw('count(portal_user_id) as value'))
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->where('is_monthly_donation', $isMonthly)
            ->groupBy(DB::raw('date'))
            ->get();
    }

    public function getDonorsAndDonationsTotal($from, $to)
    {
        return $this->model::select(
            DB::raw('count(portal_user_id) as donors_count'), DB::raw('sum(donation) as donations_sum'),
            DB::raw('avg(donation) as donations_avg'), 'is_monthly_donation')
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->groupBy(DB::raw('is_monthly_donation'))
            ->get();
    }


}