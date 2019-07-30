<?php

namespace Modules\UserManagement\Exports;

use Modules\Payment\Entities\Donation;
use Modules\UserManagement\Entities\PortalUser;
use Maatwebsite\Excel\Concerns\FromCollection;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DonorsExport implements FromCollection
{
    private $recruitedDate;
    private $userHistoricalAmount;

    public function __construct()
    {
        $this->recruitedDate = '';
        $this->userHistoricalAmount = '';
        ini_set('memory_limit', '2048M');
        ini_set('max_execution_time', 2000);
    }

    /**
     * @return array
     */
    public function collection()
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
            ->with(array('donations' => function ($query) {
                $query->select('portal_user_id', 'is_monthly_donation', 'amount', 'amount_initialized', 'status', 'payment_method', 'payment_id', 'created_at')
                    ->where('status', 'processed');
            }))
            ->with('user.userDetail')
            ->get();

        $header = array(
            'Donor ID', 'Email', 'First name', 'Last name', 'Street', 'City', 'ZIP', 'Donor type', 'IBAN', 'Variable symbol',
            'Register in', 'Agree newsletter', 'Payments created by', 'Transfer type', 'Last donation date', 'Declared amount',
            'Recruited date'
        );
        $actualMonth = (int)Carbon::now()->month;
        for ($i = (int)$this->getYearOfFirstDonation(); $i <= (int)Carbon::now()->year; $i++) {
            for ($m = 1; $m <= 12; $m++) {
                if ($i === (int)Carbon::now()->year) { // if is actual year in cycle
                    if ($m <= $actualMonth) {
                        array_push($header, (string)$m . '.' . $i);
                    }
                } else {
                    array_push($header, (string)$m . '.' . $i);
                }
            }
        }
        array_push($result, $header);
        foreach ($portalUsers as $user) {
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
                $user->created_at,
                ($user->gdrp['agree_mail_sending']) ? true : false
            );
            $createdBy = 'N/A';
            $transferType = 'N/A';
            $lastDonationDate = 'N/A';
            $declaredAmount = 0;
            $recruitedDate = 'N/A';
            $donations = $user->donations;
            $donationCounter = 0;
            foreach ($donations as $donation) {
                if ($donation->status == 'processed') {
                    if ($donationCounter === 0) {
                        // store last donation information
                        $createdBy = $donation->payment['created_by'];
                        $lastDonationDate = $donation->created_at;
                        $declaredAmount = $donation->amount_initialized;
                        switch ($donation->transfer_type) {
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
                        break;

                    }
                    $donationCounter++;
                }
            }
            array_push($row, $createdBy, $transferType, $lastDonationDate, $declaredAmount, $recruitedDate);

            $actualMonth = (int)Carbon::now()->month;
            $this->userHistoricalAmount = '';
            for ($i = (int)$this->getYearOfFirstDonation(); $i <= (int)Carbon::now()->year; $i++) {
                for ($m = 1; $m <= 12; $m++) {
                    if ($i === (int)Carbon::now()->year) { // if is actual year in cycle
                        if ($m <= $actualMonth) {
                            array_push($row, $this->getDonationsOfMonth($user->id, $user->donations, $m, $i));
                        }
                    } else {
                        array_push($row, $this->getDonationsOfMonth($user->id, $user->donations, $m, $i));
                    }
                }
            }

            if (preg_match('/^0+$/', $this->userHistoricalAmount) && $row[15] === 0) {
                $row[7] = 'not supporter';
            }

            array_push($result, $row);

        }
        return $result;
    }


    private function getDonationsOfMonth($portal_user_id, $donations, $month, $year)
    {
        $sum = 0;

        $date = '';

        foreach ($donations as $donation) {
            $date = $donation->created_at;
            $donationMonth = (int)Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('m');
            $donationYear = (int)Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y');
            if ($donationMonth === $month && $donationYear === $year) {
                $sum += $donation->amount;
            }
        }
        $this->userHistoricalAmount = (string)((int)$sum);
        preg_match('/00[1-9]$/', $this->userHistoricalAmount, $matchOutput);
        if ($matchOutput !== null) {
            $this->recruitedDate = $date;
        }
        return $sum;
    }

    private function getYearOfFirstDonation()
    {
        $firstDonation = Donation
            ::where('status', 'processed')
            ->orderBy('created_at', 'ASC')
            ->first();
        return Carbon::createFromFormat('Y-m-d H:i:s', $firstDonation->created_at)->year;
    }

    private function months()
    {
        $arr = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'Novemebr', 'December'];
        return $arr;
    }
}
