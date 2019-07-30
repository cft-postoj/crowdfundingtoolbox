<?php

namespace Modules\Statistics\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Payment\Entities\Donation;
use Modules\Payment\Entities\Payment;

class StatsDonationRepository implements StatsDonationRepositoryInterface
{

    protected $model;

    function __construct()
    {
        $this->model = Donation::class;
    }

    public function getDonationsGroupIsMonthly($from, $to, $interval, $isMonthly)
    {
        $payment = Payment::query()
            ->select('id')
            ->whereDate('transaction_date', '>=', $from)
            ->whereDate('transaction_date', '<=', $to);

        return $this->model::select(
            DB::raw("date_trunc('$interval', created_at) AS date"), DB::raw('sum(amount) as value'))
            ->joinSub($payment, 'payment', function ($join) {
                $join->on('donations.payment_id', '=', 'payment.id');
            })
            ->where('is_monthly_donation', $isMonthly)
            ->groupBy(DB::raw('date'))
            ->get();
    }

    public function getDonorsGroupIsMonthly($from, $to, $interval, $isMonthly)
    {
        $payment = Payment::query()
            ->select('id')
            ->whereDate('transaction_date', '>=', $from)
            ->whereDate('transaction_date', '<=', $to);

        return $this->model::select(
            DB::raw("date_trunc('$interval', created_at) AS date"), DB::raw('count(portal_user_id) as value'))
            ->joinSub($payment, 'payment', function ($join) {
                $join->on('donations.payment_id', '=', 'payment.id');
            })
            ->where('is_monthly_donation', $isMonthly)
            ->where('status', 'processed')
            ->groupBy(DB::raw('date'))
            ->get();
    }

    public function getDonorsAndDonationsTotal($from, $to)
    {
        return Payment::query()
            ->select(DB::raw('sum(payments.amount) as amount_sum'),
                DB::raw('avg(payments.amount) as amount_avg'),
                DB::raw( 'count(DISTINCT portal_user_id) as donors_count')
            )
            ->leftJoin('donations', 'payments.id', '=', 'donations.payment_id')
            ->whereDate('transaction_date', '>=', $from)
            ->whereDate('transaction_date', '<=', $to)
            ->first();
    }

    public function getDonorsAndDonationsTotalGroupMonthly($from, $to)
    {
         return Payment::query()
            ->select(DB::raw('sum(payments.amount) as amount_sum'),
                DB::raw('avg(payments.amount) as amount_avg'),
                DB::raw( 'count(DISTINCT portal_user_id) as donors_count'),
                'is_monthly_donation'
            )
            ->leftJoin('donations', 'payments.id', '=', 'donations.payment_id')
            ->whereDate('transaction_date', '>=', $from)
            ->whereDate('transaction_date', '<=', $to)
            ->groupBy(DB::raw('is_monthly_donation'))
            ->get();
    }

    public function getDonations($from, $to, $monthly)
    {
        $query = Donation::query()
            ->has('portalUser')
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->with(['portalUser.user.userDetail', 'widget.campaign', 'widget.widgetType','payment.paymentMethod']);

        //if monthly is set, filter lastDonationAt
        if ($monthly !== null) {
            $lastDonationAt = $query->where('is_monthly_donation', $monthly);
        }
        return $query->get();
    }

}