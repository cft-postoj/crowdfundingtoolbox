<?php

namespace Modules\Payment\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Modules\Payment\Entities\Donation;
use Modules\Payment\Entities\VariableSymbol;
use Modules\Payment\Services\DonationService;
use Modules\Payment\Services\PaymentService;
use Modules\UserManagement\Entities\UserPaymentOption;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CardpayPairingFix extends Command
{

    private const CARDPAY_IBAN = 'SK7011000000002002011538';
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'payments:cardpay-pairing-fix';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'During import of all donation from cvs, one user was pairing CP payments via iban to his account. 
                              This command should unpair his payments from CP and preserve only payments with his VS';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(DonationService $donationService)
    {
        $userPaymentWithCardpayIban = UserPaymentOption::query()
            ->where('bank_account_number', self::CARDPAY_IBAN)
            ->first();
        $portalUserId = $userPaymentWithCardpayIban->portal_user_id;
        $cardPayUserVs = VariableSymbol::query()
            ->select('variable_symbol')
            ->where('portal_user_id', $portalUserId)
            ->first('variable_symbol')->variable_symbol;

        $donations = Donation::query()
            ->where('portal_user_id', $portalUserId)
            ->whereHas('payment')
            ->with('payment')
            ->get();
        $count = 0;
        foreach ($donations as $donation) {
            $paymentVariableSymbol = $donation->payment->variable_symbol;
            if ($donation->payment_method === 2 && $paymentVariableSymbol !== $cardPayUserVs) {
                $updateVariableSymbol = VariableSymbol::query()
                    ->where('variable_symbol', $paymentVariableSymbol)
                    ->first();
                if ($updateVariableSymbol == null) {
                    Log::info('No user has variable symbol ' . $paymentVariableSymbol );
                } else {
                    $newPortalUserId = $updateVariableSymbol->portal_user_id;
                    $donation->portal_user_id = $newPortalUserId;
                    Log::info('Pair donation, that was paired to user with portal_user ' . $portalUserId .
                        ' to portal user with id: ' . $newPortalUserId . ' donation data: ' . json_encode($donation));
                    $count += $donation->update();
                }
            }
        }
        dump('Successfully paired ' . $count . ' donations to happy users');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }
}
