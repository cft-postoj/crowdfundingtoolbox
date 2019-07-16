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
        $users = $this->statsDonorService->getDonors('2019-05-06', '2019-06-06', null,
            'stoppedSupporting', null);
        $header = array(
            'Email', 'First name', 'Last name', 'Street', 'City', 'ZIP', 'Donor type', 'IBAN', 'Variable symbol',
            'Transfer type', 'Declared amount', 'Sum of all donations'
        );
        array_push($result, $header);
        foreach ($users as $user) {
            $paymentMethod = '';
            switch ($user[0]->last_donation_payment_method) {
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
            }
            $iban = UserPaymentOption::where('portal_user_id', $user[0]->id)->first()['bank_account_number'];

            $row = array(
                $user->user->email,
                $user->userDetail->first_name,
                $user->userDetail->last_name,
                $user->userDetail->street . ' ' . $user->userDetail->house_number,
                $user->userDetail->city,
                $user->userDetail->zip,
                $iban,
                $user->variableSymbol->variable_symbol,
                $paymentMethod,
                $user[0]->last_donation_value,
                $user[0]->amount_sum
            );
            array_push($result, $row);
        }
        return $result;
    }
}