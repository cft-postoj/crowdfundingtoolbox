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

    public function getDonationsBetweenMonthly($from, $to, $interval, $isMonthly)
    {
        return  Donation::select(
            DB::raw("date_trunc('$interval', created_at) AS date"), DB::raw('sum(donation) as value'))
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<', $to)
            ->where('is_monthly_donation', $isMonthly)
            ->groupBy(DB::raw('date'))
            ->get();
    }

}