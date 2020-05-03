<?php


namespace Modules\UserManagement\Exports;


use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Modules\UserManagement\Entities\UserPaymentOption;
use Modules\UserManagement\Services\PortalUserService;

class NotCompleteSupportExport implements FromCollection
{
    private $from;
    private $to;
    protected $portalUserService;

    public function __construct(PortalUserService $portalUserService)
    {
        ini_set('memory_limit', '2048M');
        ini_set('max_execution_time', 2000);
        $this->portalUserService = $portalUserService;
    }

    public function getData($from, $to) {
        $this->from = $from;
        $this->to = $to;
        return $this->collection();
    }

    /**
     * @return array
     */
    public function collection()
    {
        $result = array();
        $users = $this->portalUserService->getPortalUsers($this->from, $this->to, null,
            'onlyInitializeDonation', null, []);
        $header = array(
            'Email', 'First name', 'Last name', 'Street', 'City', 'ZIP', 'Donation type', 'IBAN', 'Variable symbol',
            'Transfer type', 'Initialized amount', 'Last donation amount', 'Sum of all donations', 'Date of last donation'
        );
        array_push($result, $header);
        foreach ($users as $user) {
            $paymentMethod = '';
            $methodId = $user->last_donation_payment_method;
            switch ($methodId) {
                case 1:
                    $paymentMethod = 'Bank transfer';
                    break;
                case 2:
                    $paymentMethod = 'Cardpay';
                    break;
                case 3:
                    $paymentMethod = 'Pay By Square';
                    break;
                case 4:
                    $paymentMethod = 'Google Pay';
                    break;
                case 5:
                    $paymentMethod = 'Apple Pay';
                    break;
            }
            $iban = UserPaymentOption::where('portal_user_id', $user->id)->first()['bank_account_number'];
            $lastDonationAmount = ($user->lastUserDonation) ? $user->lastUserDonation->amount : ' - ';
            $dateOfLastDonation = ($user->lastUserDonation) ? Carbon::createFromFormat('Y-m-d H:i:s', $user->lastUserDonation->trans_date)->format('d.m.Y H:i:s') : ' - ';

            $row = array(
                $user->user->email,
                $user->user->userDetail->first_name,
                $user->user->userDetail->last_name,
                $user->user->userDetail->street . ' ' . $user->user->userDetail->house_number,
                $user->user->userDetail->city,
                $user->user->userDetail->zip,
                ($user->last_donation_monthly) ? 'monthly' : 'one-time',
                $iban,
                $user->variableSymbol->variable_symbol,
                $paymentMethod,
                $user->amount_initialized,
                $lastDonationAmount,
                $user->amount_sum,
                $dateOfLastDonation
            );
            array_push($result, $row);
        }
        return $result;
    }

}