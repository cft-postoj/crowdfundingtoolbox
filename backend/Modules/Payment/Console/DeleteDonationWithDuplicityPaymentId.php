<?php

namespace Modules\Payment\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Payment\Entities\Donation;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class DeleteDonationWithDuplicityPaymentId extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'donations:delete-donation-with-duplicity-payment-id';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find all donations connected to same payment id and remove all donations except the newest.';

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
    public function handle()
    {

        Log::info('Starting command');
        dump('Starting command');
        $payment_ids = collect(DB::select('select payment_id
                                                    from donations
                                                    where donations.deleted_at is null
                                                    group by payment_id
                                                    having count(payment_id) > 1'));
        $payment_ids = $payment_ids->map(function ($id) {
            return $id->payment_id;
        });
        $donations = Donation::query()->whereIn('payment_id', $payment_ids)->get();

        $donationsDeleted = 0;
        $paymentsFixed = 0;
        foreach ($donations->groupBy('payment_id') as $donationWithSamePaymentId) {
            $donationWithSamePaymentId = $donationWithSamePaymentId->sortByDesc('created_at');
            $donationWithSamePaymentId->values()->all();
            foreach ($donationWithSamePaymentId as $key => $donation) {
                if ($key > 0) {
                    $donation->payment_id = null;
                    $donation->update();
                    $donation->delete();
                    $donationsDeleted++;
                }
            }
            $paymentsFixed++;
        }
        Log::info("Command successfully finished. Deleting $donationsDeleted donations and fixed $paymentsFixed payments.");
        dump("Command successfully finished. Deleting $donationsDeleted donations and fixed $paymentsFixed payments.");
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
