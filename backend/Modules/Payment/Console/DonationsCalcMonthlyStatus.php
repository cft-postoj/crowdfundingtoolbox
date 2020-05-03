<?php

namespace Modules\Payment\Console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Modules\Payment\Services\DonationService;
use Modules\Payment\Services\PaymentService;
use Modules\UserManagement\Entities\PortalUser;
use Modules\UserManagement\Services\PortalUserService;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class DonationsCalcMonthlyStatus extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'donations:calc-monthly-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all donations where donation.is_monthly_donation is false, then recalc then if this
     status is correct. If donations should be monthly, change this status';

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
     * @param DonationService $donationService
     * @return mixed
     */
    public function handle(PortalUserService $portalUserService)
    {
        $portalUsers = $portalUserService->getAllWithOneTimeDonation();
        foreach ($portalUsers as $portalUser) {
            foreach ($portalUser->donations as $donation) {
                if ($donation->is_monthly_donation === false && $donation->payment_id !== null && $donation->payment->transfer_type === 1) {
                    $donationDate = Carbon::parse($donation->payment->transaction_date);
                    foreach ($portalUser->donations as $previousDonation) {
                        if($previousDonation !== $donation && $previousDonation->payment !== null && $previousDonation->payment_id !== null
                            && $donation->amount === $previousDonation->amount) {
                            $previousDonationDate = Carbon::parse($previousDonation->payment->transaction_date);
                            if ($donationDate->diffInDays($previousDonationDate) < 35 &&
                                $donation->amount === $previousDonation->amount) {
                                $donation->is_monthly_donation = true;
                                $donation->save();
                                Log::info('donation updated: ' . json_encode($donation) .
                                    ' previous donation: ' . json_encode($previousDonation) .
                                    'amount diff: ' . $donationDate->diffInDays($previousDonationDate));
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['example', InputArgument::OPTIONAL, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
