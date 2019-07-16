<?php


namespace Modules\UserManagement\Exports;


use Maatwebsite\Excel\Concerns\FromCollection;
use Modules\Statistics\Services\StatsDonorService;
use Carbon\Carbon;
use Modules\UserManagement\Entities\UserPaymentOption;

class StoppedSupportingExport implements FromCollection
{

    protected $statsDonorService;
    private $from;
    private $to;

    public function __construct(StatsDonorService $statsDonorService)
    {
        ini_set('memory_limit', '2048M');
        ini_set('max_execution_time', 2000);
        $this->statsDonorService = $statsDonorService;
    }

    public function getData($from, $to)
    {
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
        $users = $this->statsDonorService->getDonors($this->from, $this->to, null,
            'stoppedSupporting', null);
        $header = array(
            'Email', 'First name', 'Last name', 'Street', 'City', 'ZIP', 'Donor type', 'IBAN', 'Variable symbol',
            'Transfer type', 'Declared amount', 'Last donation amount', 'Sum of all donations', 'Date of last donation'
        );
        array_push($result, $header);
        foreach ($users->donors as $user) {
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
            $row = array(
                $user->user->email,
                $user->user->userDetail->first_name,
                $user->user->userDetail->last_name,
                $user->user->userDetail->street . ' ' . $user->user->userDetail->house_number,
                $user->user->userDetail->city,
                $user->user->userDetail->zip,
                ($user->isMonthlyDonor) ? 'monthly donor' : 'one-time supporter',
                $iban,
                $user->variableSymbol->variable_symbol,
                $paymentMethod,
                $user->firstDonation->amount_intitialized,
                $user->last_donation_value,
                $user->amount_sum,
                $user->last_donation_at
            );
            array_push($result, $row);
        }
        return $result;
    }
}