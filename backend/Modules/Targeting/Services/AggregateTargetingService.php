<?php


namespace Modules\Targeting\Services;


use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Modules\Payment\Entities\Donation;
use Modules\Payment\Entities\Payment;
use Modules\Targeting\Entities\AggregateTargeting;
use Modules\UserManagement\Entities\PortalUser;
use Modules\UserManagement\Entities\TrackingVisit;
use Modules\UserManagement\Entities\UserCookieCouple;
use Modules\UserManagement\Entities\UserDetail;

class AggregateTargetingService
{

    public function __construct()
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 2000);
    }

    public function doUserJob($portal_user_id)
    {
        try {
            $data = PortalUser::where('id', $portal_user_id)
                ->with('user')
                ->with('isMonthlyDonor')
                ->with('getAllDonationsByUser')
                ->first();
            $userDetail = UserDetail::where('user_id', $data->user->id)->first();
            $hasValidAddress = false;
            if ($userDetail->first_name && $userDetail->last_name && $userDetail->street &&
                $userDetail->zip && $userDetail->city) {
                $hasValidAddress = true;
            }
            $name = ($userDetail->first_name) ? trim($userDetail->first_name) : '';
            $name .= ($userDetail->last_name) ? ' ' . trim($userDetail->last_name) : '';

            $lastDonation = $this->lastDonation($data->id);

            $readArticles = $this->readArticles($data->id);

            $userData = array(
                'portal_user_id' => $data->id,
                'user_id' => $data->user->id,
                'email' => $data->user->email,
                'name' => $name,
                'has_valid_address' => $hasValidAddress,
                'is_supporter' => $lastDonation['isSupporter'],
                'last_donation_before' => $lastDonation['donationBefore'],
                'last_donation_value' => $lastDonation['donationValue'],
                'last_donation_id' => $lastDonation['donationId'],
                'monthly_supporter' => ($data->isMonthlyDonor == null) ? false : true,
                'all_donations' => json_encode($data->getAllDonationsByUser),
                'read_articles_today' => $readArticles['today'],
                'read_articles_week' => $readArticles['week'],
                'read_articles_month' => $readArticles['month'],
                'unlocked_at' => $data->unlocked_at
            );
            $this->makeRecord((object)$userData);
        } catch (\Exception $exception) {
            Log::error('Aggregate Targeting JOB -- ERROR -- ' . json_encode($exception));
            Log::error('Aggregate Targeting JOB -- ERROR MSG -- ' . $exception->getMessage());
        }
        //Log::info('Aggregate Targeting JOB -- SUCCESS -- Successfully created/updated portal user: ' . $portal_user_id);

    }

    public function doJob($from, $to)
    {

        Log::info('Aggregate Targeting JOB -- STARTED with order FROM: ' . $from . ' TO: ' . $to . ' MAX_EXECUTION_TIME: ' . ini_get('max_execution_time'));
        $logCounter = 0;
        try {

            if ($from !== null && $to !== null) {
                $usersData = PortalUser::with('user')
                    ->with('isMonthlyDonor')
                    ->with('getAllDonationsByUser')
                    ->where('id', '>=', $from)
                    ->where('id', '<=', $to)
                    ->get();
            } else {
                $usersData = PortalUser::with('user')
                    ->with('isMonthlyDonor')
                    ->with('getAllDonationsByUser')
                    ->get();
            }

            foreach ($usersData as $data) {
                $userDetail = UserDetail::where('user_id', $data->user->id)->first();
                $hasValidAddress = false;
                if ($userDetail->first_name && $userDetail->last_name && $userDetail->street &&
                    $userDetail->zip && $userDetail->city) {
                    $hasValidAddress = true;
                }
                $name = ($userDetail->first_name) ? trim($userDetail->first_name) : '';
                $name .= ($userDetail->last_name) ? ' ' . trim($userDetail->last_name) : '';

                $lastDonation = $this->lastDonation($data->id);

                $readArticles = $this->readArticles($data->id);

                $userData = array(
                    'portal_user_id' => $data->id,
                    'user_id' => $data->user->id,
                    'email' => $data->user->email,
                    'name' => $name,
                    'has_valid_address' => $hasValidAddress,
                    'is_supporter' => $lastDonation['isSupporter'],
                    'last_donation_before' => $lastDonation['donationBefore'],
                    'last_donation_value' => $lastDonation['donationValue'],
                    'last_donation_id' => $lastDonation['donationId'],
                    'monthly_supporter' => ($data->isMonthlyDonor == null) ? false : true,
                    'all_donations' => json_encode($data->getAllDonationsByUser),
                    'read_articles_today' => $readArticles['today'],
                    'read_articles_week' => $readArticles['week'],
                    'read_articles_month' => $readArticles['month'],
                    'unlocked_at' => $data->unlocked_at
                );
                $this->makeRecord((object)$userData);
                $logCounter++;
                dump('inserted ' . $logCounter);
            }
        } catch (\Exception $exception) {
            Log::error('Aggregate Targeting JOB -- ERROR -- ' . json_encode($exception));
            Log::error('Aggregate Targeting JOB -- ERROR MSG -- ' . $exception->getMessage());
        }


        Log::info('Aggregate Targeting JOB -- SUCCESS -- Successfully created/updated ' . $logCounter . ' records with order FROM: ' . $from . ' TO: ' . $to);


    }

    private function makeRecord($userData)
    {
        try {
            if (AggregateTargeting::where('portal_user_id', $userData->portal_user_id)->first() !== null) {
                // update portal user record
                AggregateTargeting::where('portal_user_id', $userData->portal_user_id)->update(array(
                    'email' => $userData->email,
                    'name' => $userData->name,
                    'has_valid_address' => $userData->has_valid_address,
                    'is_supporter' => $userData->is_supporter,
                    'last_donation_before' => $userData->last_donation_before,
                    'last_donation_value' => $userData->last_donation_value,
                    'last_donation_id' => $userData->last_donation_id,
                    'monthly_supporter' => $userData->monthly_supporter,
                    'all_donations' => $userData->all_donations,
                    'read_articles_today' => $userData->read_articles_today,
                    'read_articles_week' => $userData->read_articles_week,
                    'read_articles_month' => $userData->read_articles_month,
                    'unlocked_at' => $userData->unlocked_at
                ));
            } else {
                // create portal user record
                AggregateTargeting::create(array(
                    'portal_user_id' => $userData->portal_user_id,
                    'user_id' => $userData->user_id,
                    'email' => $userData->email,
                    'name' => $userData->name,
                    'has_valid_address' => $userData->has_valid_address,
                    'is_supporter' => $userData->is_supporter,
                    'last_donation_before' => $userData->last_donation_before,
                    'last_donation_value' => $userData->last_donation_value,
                    'last_donation_id' => $userData->last_donation_id,
                    'monthly_supporter' => $userData->monthly_supporter,
                    'all_donations' => $userData->all_donations,
                    'read_articles_today' => $userData->read_articles_today,
                    'read_articles_week' => $userData->read_articles_week,
                    'read_articles_month' => $userData->read_articles_month,
                    'unlocked_at' => $userData->unlocked_at
                ));
            }
        } catch (\Exception $exception) {
            Log::error('AGGREGATE TARGETING -- ERROR -- ' . $exception->getMessage());
            dd($exception->getMessage());
        }

    }

    private function lastDonation($portal_user_id)
    {
        // if in last year (365 days ago) created some payment
        $isSupporter = false;
        $lastDonationBefore = null;
        $lastDonationValue = null;
        $donationId = null;
        $donation = Donation::where('portal_user_id', $portal_user_id)
            ->whereNotNull('payment_id')
            ->orderByDesc('id')
            ->first();
        if ($donation !== null) {
            $payment = Payment::where('id', $donation->payment_id)->first();
            if (Carbon::now()->subDays(365) < Carbon::createFromFormat('Y-m-d H:i:s', $payment->transaction_date)) {
                $isSupporter = true;
            }
            $lastDonationBefore = Carbon::createFromFormat('Y-m-d H:i:s', $payment->transaction_date)->diffInDays() - Carbon::now()->diffInDays();
            $lastDonationValue = $donation->amount;
            $donationId = $donation->id;
        }
        return collect(array(
            'isSupporter' => $isSupporter,
            'donationBefore' => $lastDonationBefore,
            'donationValue' => $lastDonationValue,
            'donationId' => $donationId
        ));
    }

    private function readArticles($portal_user_id)
    {
        $today = TrackingVisit::where('portal_user_id', $portal_user_id)
            ->whereDate('created_at', '>=', Carbon::today())
            ->get()->count();
        $week = TrackingVisit::where('portal_user_id', $portal_user_id)
            ->whereDate('created_at', '>=', Carbon::today()->subDays(7))
            ->get()->count();
        $month = TrackingVisit::where('portal_user_id', $portal_user_id)
            ->whereDate('created_at', '>=', Carbon::today()->subDays(30))
            ->get()->count();

        return collect(array(
            'today' => $today,
            'week' => $week,
            'month' => $month
        ));
    }
}