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
            ->select('id', 'payments.transaction_date', 'amount')
            ->whereDate('payments.transaction_date', '>=', $from)
            ->whereDate('payments.transaction_date', '<=', $to);

        $donationQuery = Donation::query()->select(
            DB::raw("date_trunc('$interval', payment.transaction_date) AS date"), DB::raw('sum(payment.amount) as value'))
            ->rightJoinSub($payment, 'payment', function ($join) {
                $join->on('donations.payment_id', '=', 'payment.id');
            })
            ->groupBy(DB::raw('date'));
        if ($isMonthly === false) {
            $donationQuery->where('is_monthly_donation', false)->orWhereNull('is_monthly_donation');
        } else {
            $donationQuery->where('is_monthly_donation', true);
        }
        return $donationQuery->get();
    }

    public function getDonorsGroupIsMonthly($from, $to, $interval, $isMonthly)
    {
        $payment = Payment::query()
            ->select('id', 'payments.transaction_date', 'amount')
            ->whereDate('payments.transaction_date', '>=', $from)
            ->whereDate('payments.transaction_date', '<=', $to);

        return Donation::select(
            DB::raw("date_trunc('$interval', payment.transaction_date) AS date"), DB::raw('count(portal_user_id) as value'))
            ->rightJoinSub($payment, 'payment', function ($join) {
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
                DB::raw('count(DISTINCT portal_user_id) as donors_count')
            )
            ->leftJoin('donations', function ($leftJoin) {
                $leftJoin->on('payments.id', '=', 'donations.payment_id')
                    ->whereNull('donations.deleted_at');
            })
            ->whereDate('payments.transaction_date', '>=', $from)
            ->whereDate('payments.transaction_date', '<=', $to)
            ->first();
    }

    public function getDonorsAndDonationsTotalGroupMonthly($from, $to)
    {
        return Payment::query()
            ->select(DB::raw('sum(payments.amount) as amount_sum'),
                DB::raw('avg(payments.amount) as amount_avg'),
                DB::raw('count(DISTINCT portal_user_id) as donors_count'),
                'is_monthly_donation'
            )
            ->leftJoin('donations', function ($leftJoin) {
                $leftJoin->on('payments.id', '=', 'donations.payment_id')
                    ->whereNull('donations.deleted_at');
            })
            ->whereDate('transaction_date', '>=', $from)
            ->whereDate('transaction_date', '<=', $to)
            ->groupBy(DB::raw('is_monthly_donation'))
            ->get();
    }

}
