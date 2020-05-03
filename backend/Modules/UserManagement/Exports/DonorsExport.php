<?php

namespace Modules\UserManagement\Exports;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Modules\Payment\Entities\Payment;
use Modules\UserManagement\Entities\AggExportUser;
use Modules\UserManagement\Entities\PortalUser;
use Maatwebsite\Excel\Concerns\FromCollection;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DonorsExport implements FromCollection
{
    private $recruitedDate;
    private $userHistoricalAmount;
    private $passedUserId;

    public function __construct()
    {
        $this->recruitedDate = '';
        $this->userHistoricalAmount = '';
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 2000);
    }

    /**
     * @return array
     */
    public function collection()
    {
        $result = array();
        $header = array(
            'Donor ID', 'Email', 'First name', 'Last name', 'Street', 'City', 'ZIP', 'Donor type', 'IBAN', 'Variable symbol',
            'Register in', 'Transfer type', 'Last donation date', 'Declared amount', 'Recruited date'
        );
        $actualMonth = (int)Carbon::now()->month;
        for ($i = (int)$this->getYearOfFirstDonation(); $i <= (int)Carbon::now()->year; $i++) {
            for ($m = 1; $m <= 12; $m++) {
                $resM = $m;
                if ($m < 10) {
                    $resM = '0' . $m;
                }
                if ($i === (int)Carbon::now()->year) { // if is actual year in cycle
                    if ($m <= $actualMonth) {
                        array_push($header, $resM . '/' . $i);
                    }
                } else {
                    array_push($header, $resM . '/' . $i);
                }
            }
        }
        array_push($result, $header);

        // Get all data from Aggregate Export Users
        $data = AggExportUser::orderBy('donor_id')->get();
        foreach ($data as $d) {
            $row = array();
            array_push($row, array(
                $d->donor_id,
                $d->email,
                $d->first_name,
                $d->last_name,
                $d->street,
                $d->city,
                $d->zip,
                $d->donor_type,
                $d->iban,
                $d->variable_symbol,
                $d->register_in,
                $d->transfer_type,
                $d->last_donation_date,
                $d->declared_amount,
                $d->recruited_date
            ));

            $monthlyDonations = json_decode($d->monthly_donations);
            foreach ($monthlyDonations as $donation) {
                array_push($row[0], $donation->sum);
            }
            array_push($result, array_merge(...$row));
        }
        return $result;
    }

    public function makeExportUserRecord($portal_user_id)
    {
        $portalUser = PortalUser
            ::where('id', $portal_user_id)
            ->with(array('user' => function ($query) {
                $query->select('id', 'email');
            }))
            ->with(array('variableSymbol' => function ($query) {
                $query->select('portal_user_id', 'variable_symbol');
            }))
            ->with('isMonthlyDonor')
            ->with(array('userPaymentOptions' => function ($query) {
                $query->select('portal_user_id', 'bank_account_number');
            }))
            ->with('user.userDetail')
            ->with('lastGiftDonation')
            ->first();
        $userDonationsByMonths = collect(DB::select(DB::raw("select date_trunc('month', p.transaction_date) donation_date, d.portal_user_id portal_user_id, sum(p.amount) amount from payments p join donations d on p.id = d.payment_id where d.portal_user_id = $portal_user_id group by donation_date, d.portal_user_id order by portal_user_id asc")));
        $userDonationsByMonths->groupBy('portal_user_id')->groupBy('donation_date');

        $transferType = ' - ';
        $lastDonationDate = ' - ';
        $declaredAmount = 0;
        if ($portalUser->lastGiftDonation !== null) {
            $lastDonationDate = Carbon::createFromFormat('Y-m-d H:i:s', $portalUser->lastGiftDonation->trans_date)->format('d.m.Y H:i:s');
            $declaredAmount = ($portalUser->lastGiftDonation->amount_initialized == null) ? 0 : $portalUser->lastGiftDonation->amount_initialized;
            switch ($portalUser->lastGiftDonation->transfer_type) {
                case 1:
                    $transferType = 'Bank transfer';
                    break;
                case 2:
                    $transferType = 'Cardpay';
                    break;
                case 3:
                    $transferType = 'Pay By Square';
                    break;
                case 4:
                    $transferType = 'Google Pay';
                    break;
                case 5:
                    $transferType = 'Apple Pay';
            }
        }

        $usersDonationsByMonthsLayout = array();
        for ($i = (int)$this->getYearOfFirstDonation(); $i <= (int)Carbon::now()->year; $i++) {
            for ($m = 1; $m <= 12; $m++) {

                array_push($usersDonationsByMonthsLayout, array(
                    'date' => Carbon::createFromDate($i, $m, 1),
                    'sum' => 0
                ));
            }
        }

        $monthlyDonations = array();

        $recruited_date = ' - ';
        $indexLayout = 0;
        $notSupporter = true;
        foreach ($usersDonationsByMonthsLayout as $monthLayout) {
            foreach ($userDonationsByMonths as $userDonation) {
                if ($monthLayout['date']->startOfMonth()->format('m/Y') === Carbon::createFromFormat('Y-m-d H:i:s', $userDonation->donation_date)->format('m/Y')) {
                    $monthLayout['sum'] = $userDonation->amount;
                    if ($indexLayout !== 0) {
                        $actualIndex = $indexLayout - 1;
                        if ($monthlyDonations[$actualIndex]['sum'] === 0) {
                            $recruited_date = $monthLayout['date']->format('m/Y');
                            $notSupporter = false;
                        }
                    }
                }
            }
            $monthLayout['date'] = $monthLayout['date']->format('m/Y');
            array_push($monthlyDonations, $monthLayout);
            $indexLayout++;
        }

        $aggExportUserRecord = AggExportUser::where('donor_id', $portal_user_id)->first();
        if ($aggExportUserRecord === null) {
            AggExportUser::create([
                'donor_id' => $portal_user_id,
                'email' => $portalUser->user->email,
                'first_name' => ($portalUser->user->userDetail->first_name) ? $portalUser->user->userDetail->first_name : ' - ',
                'last_name' => ($portalUser->user->userDetail->last_name) ? $portalUser->user->userDetail->last_name : ' - ',
                'street' => ($portalUser->user->userDetail->street) ? $portalUser->user->userDetail->street . ($portalUser->user->userDetail->house_number ? ' ' . $portalUser->user->userDetail->house_number : '') : ' - ',
                'city' => ($portalUser->user->userDetail->city) ? $portalUser->user->userDetail->city : ' - ',
                'zip' => ($portalUser->user->userDetail->zip) ? $portalUser->user->userDetail->zip : ' - ',
                'donor_type' => ($portalUser->isMonthlyDonor !== null) ? 'Monthly donor' : 'One-time supporter',
                'iban' => ($portalUser->userPaymentOptions->bank_account_number) ? $portalUser->userPaymentOptions->bank_account_number : ' - ',
                'variable_symbol' => ($portalUser->variableSymbol) ? $portalUser->variableSymbol->variable_symbol : ' - ',
                'register_in' => (!$portalUser->locked_account) ? Carbon::createFromFormat('Y-m-d H:i:s', $portalUser->unlocked_at)->format('d.m.Y H:i:s') : 'locked account',
                'transfer_type' => $transferType,
                'last_donation_date' => $lastDonationDate,
                'declared_amount' => $declaredAmount,
                'recruited_date' => $recruited_date,
                'monthly_donations' => json_encode($monthlyDonations)
            ]);
        } else {
            $aggExportUserRecord->update([
                'email' => $portalUser->user->email,
                'first_name' => ($portalUser->user->userDetail->first_name) ? $portalUser->user->userDetail->first_name : ' - ',
                'last_name' => ($portalUser->user->userDetail->last_name) ? $portalUser->user->userDetail->last_name : ' - ',
                'street' => ($portalUser->user->userDetail->street) ? $portalUser->user->userDetail->street . ($portalUser->user->userDetail->house_number ? ' ' . $portalUser->user->userDetail->house_number : '') : ' - ',
                'city' => ($portalUser->user->userDetail->city) ? $portalUser->user->userDetail->city : ' - ',
                'zip' => ($portalUser->user->userDetail->zip) ? $portalUser->user->userDetail->zip : ' - ',
                'donor_type' => ($portalUser->isMonthlyDonor !== null) ? 'Monthly donor' : ($notSupporter) ? 'Not supporter' : 'One-time supporter',
                'iban' => ($portalUser->userPaymentOptions->bank_account_number) ? $portalUser->userPaymentOptions->bank_account_number : ' - ',
                'variable_symbol' => ($portalUser->variableSymbol) ? $portalUser->variableSymbol->variable_symbol : ' - ',
                'register_in' => (!$portalUser->locked_account) ? Carbon::createFromFormat('Y-m-d H:i:s', $portalUser->unlocked_at)->format('d.m.Y H:i:s') : 'locked account',
                'transfer_type' => $transferType,
                'last_donation_date' => $lastDonationDate,
                'declared_amount' => $declaredAmount,
                'recruited_date' => $recruited_date,
                'monthly_donations' => json_encode($monthlyDonations)
            ]);
        }
    }

    public function usersExportJob()
    {
        $result = array();
        $portalUsers = PortalUser
            ::with(array('user' => function ($query) {
                $query->select('id', 'email');
            }))
            ->with(array('variableSymbol' => function ($query) {
                $query->select('portal_user_id', 'variable_symbol');
            }))
            ->with('isMonthlyDonor')
            ->with(array('userPaymentOptions' => function ($query) {
                $query->select('portal_user_id', 'bank_account_number');
            }))
            ->with('user.userDetail')
            ->with('lastGiftDonation')
            ->get();


        // Get sum of all user donations from 2015
        $usersDonationsByMonths = collect(DB::select(DB::raw("select date_trunc('month', p.transaction_date) donation_date, d.portal_user_id portal_user_id, sum(p.amount) amount from payments p join donations d on p.id = d.payment_id group by donation_date, d.portal_user_id order by portal_user_id asc")));

        $usersDonationsByMonths->groupBy('portal_user_id')->groupBy('donation_date');

        $header = array(
            'Donor ID', 'Email', 'First name', 'Last name', 'Street', 'City', 'ZIP', 'Donor type', 'IBAN', 'Variable symbol',
            'Register in', 'Agree newsletter', 'Transfer type', 'Last donation date', 'Declared amount',
            'Recruited date'
        );
        $actualMonth = (int)Carbon::now()->month;
        $usersDonationsByMonthsLayout = array();
        for ($i = (int)$this->getYearOfFirstDonation(); $i <= (int)Carbon::now()->year; $i++) {
            for ($m = 1; $m <= 12; $m++) {
                if ($i === (int)Carbon::now()->year) { // if is actual year in cycle
                    if ($m <= $actualMonth) {
                        array_push($header, (string)$m . '.' . $i);
                    }
                } else {
                    array_push($header, (string)$m . '.' . $i);
                }
                array_push($usersDonationsByMonthsLayout, array(
                    'date' => Carbon::createFromDate($i, $m, 1),
                    'sum' => 0
                ));
            }
        }
        array_push($result, $header);

        $ccc = 0;
        foreach ($portalUsers as $user) {
            dump('USERS EXPORT STARTED FOR USER ' . $user->id);
            $ccc++;
            $row = array(
                $user->id,
                $user->user->email,
                $user->user->userDetail['first_name'],
                $user->user->userDetail['last_name'],
                $user->user->userDetail['street'] . ' ' . $user->user->userDetail['house_number'],
                $user->user->userDetail->city,
                $user->user->userDetail->zip,
                ($user->isMonthlyDonor !== null) ? 'monthly' : 'one-time',
                $user->userPaymentOptions['bank_account_number'],
                $user->variableSymbol['variable_symbol'],
                $user->unlocked_at,
                ($user->gdrp['agree_mail_sending']) ? true : false
            );
            $transferType = 'N/A';
            $lastDonationDate = 'N/A';
            $declaredAmount = 0;
            $recruitedDate = 'N/A';
            // store last donation information
            if ($user->lastGiftDonation !== null):
                $lastDonationDate = $user->lastGiftDonation->created_at;
                $declaredAmount = $user->lastGiftDonation->amount_initialized;
                $transferType = '';
                switch ($user->lastGiftDonation->transfer_type) {
                    case 1:
                        $transferType = 'Bank transfer';
                        break;
                    case 2:
                        $transferType = 'Cardpay';
                        break;
                    case 3:
                        $transferType = 'Pay By Square';
                        break;
                    case 4:
                        $transferType = 'Google Pay';
                        break;
                    case 5:
                        $transferType = 'Apple Pay';
                }
            endif;
            array_push($row, $transferType, $lastDonationDate, $declaredAmount, $recruitedDate);

            $this->userHistoricalAmount = '';
            $this->passedUserId = $user->id;

            foreach ($usersDonationsByMonthsLayout as $monthLayout) {
                foreach ($usersDonationsByMonths as $userDonation) {
                    if ($monthLayout['date']->startOfMonth()->format('Y-m-d') === Carbon::createFromFormat('Y-m-d H:i:s', $userDonation->donation_date)->format('Y-m-d')) {
                        $monthLayout['sum'] = $userDonation->amount;
                    }
                }
                array_push($row, $monthLayout['sum']);
            }


            if (preg_match('/^0+$/', $this->userHistoricalAmount) && $row[15] === 0) {
                $row[7] = 'not supporter';
            }

            array_push($result, $row);
            dump('USERS EXPORT -- portal_user_id: ' . $user->id . ' -- ROW: ' . json_encode($row));
        }

        Cache::put('portalUsersExport', $result, 720);
        Log::info('EXPORT USERS JOB SUCCESS');
    }

    private function getYearOfFirstDonation()
    {
        $firstPayment = Payment::orderBy('transaction_date', 'ASC')->first();
        if ($firstPayment == null) {
            return 2015;
        }
        return Carbon::createFromFormat('Y-m-d H:i:s', $firstPayment->transaction_date)->year;
    }
}
