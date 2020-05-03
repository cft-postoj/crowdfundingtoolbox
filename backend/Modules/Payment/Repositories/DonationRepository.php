<?php


namespace Modules\Payment\Repositories;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Payment\Entities\Donation;

class DonationRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = Donation::class;
    }

    public function getById($id)
    {
        return $this->model
            ::where('id', $id)
            ->first();
    }

    public function getDetail($id)
    {
        return $this->model
            ::where('id', $id)
            ->with('payment')
            ->with('portalUser')
            ->with('portalUser.user.userDetail')
            ->first();
    }

    public function updateAssignment($portal_user_id, $id)
    {
        return $this->model
            ::where('id', $id)
            ->update(array(
                'portal_user_id' => $portal_user_id
            ));
    }

    public function create($request)
    {
        return $this->model
            ::create(
                $request
            );
    }

    public function updateRequest($donation)
    {
        return $donation->update();
    }

    public function delete($id)
    {
        return $this->model
            ::where('id', $id)
            ->delete();
    }

    public function getDonations($from, $to, $monthly, $page_size, $filterColumns)
    {
        $query = Donation::filter($filterColumns);

        if ($from !== null) {
            $query = $query->whereDate('created_at', '>=', $from);
        }
        if ($to !== null) {
            $query = $query->whereDate('created_at', '<=', $to);
        }
        //if monthly is set, filter lastDonationAt
        if ($monthly !== null) {
            $query = $query->where('is_monthly_donation', $monthly);
        }
        return $query->paginate($page_size);
    }

    public function shouldBeMonthlyDonation($portalUserId, Carbon $from, Carbon $to, $amount)
    {
        $donations = Donation::select(DB::raw('sum(amount) as donation_amount_sum'),
            DB::raw('sum(CASE when is_monthly_donation = false THEN 1 ELSE 0 END) as sum_of_one_time_payments'))
            ->whereHas('payment', function ($query) use ($from, $to) {
                $query->whereBetween('payments.transaction_date', [$from, $to]);
            })
            ->where('portal_user_id', $portalUserId)
            ->first();
        return array('monthly' => $donations->donation_amount_sum >= $amount,
            'numberOfOneTimePayments' => $donations->sum_of_one_time_payments);

    }

    public function getDonationsToUpdateStatusRetrospective($portalUserId, Carbon $from, Carbon $to, $amount)
    {
        $donations = Donation::whereHas('payment', function ($query) use ($from, $to) {
            $query->whereBetween('payments.transaction_date', [$from, $to]);
        })
            ->with(['payment' => function ($query) use ($from, $to) {
                $query->whereBetween('payments.transaction_date', [$from, $to]);
            }])
            ->where('portal_user_id', $portalUserId)
            ->get();
        return $donations;
    }

    public function getByPaymentDetails($uuid, $user_id)
    {
        return $this->model::where('uuid', $uuid)
            ->where('portal_user_id', $user_id)
            ->where('payment_id', null)
            ->first();
    }

    public function getNotPairedByPortalUser($user_id)
    {
        return $this->model::where('portal_user_id', $user_id)
            ->where('payment_id', null)
            ->orderBy('id', 'desc')
            ->first();
    }

    public function update($id, $status, $payment_method, $payment_id, $amount, $transaction_date)
    {
        $this->model::where('id', $id)
            ->update([
                'status' => $status,
                'payment_method' => $payment_method,
                'payment_id' => $payment_id,
                'amount' => $amount,
                'trans_date' => $transaction_date
            ]);
    }

    public function getLastSuccessDonationByPortalUser($portal_user_id, $isMonthlyPayment)
    {
        return $this->model::where('portal_user_id', $portal_user_id)
            ->where('is_monthly_donation', $isMonthlyPayment)
            ->where('payment_id', '!=', null)
            ->where('payment_method', 2)
            ->first();
    }

    public function lastBankTransferMonthlyDonation($portal_user_id)
    {
        return $this->model
            ::where('portal_user_id', $portal_user_id)
            ->where('payment_id', '!=', null)
            ->where('is_monthly_donation', true)
            ->where('payment_method', 1)
            ->orderByDesc('created_at')
            ->first();
    }

    public function getByPaymentId($payment_id)
    {
        return $this->model
            ::where('payment_id', $payment_id)
            ->orderBy('id')
            ->get();
    }

    public function deleteAllDonationByPortalUserId($id)
    {
        return Donation::query()
            ->where('portal_user_id', $id)
            ->delete();
    }


}
