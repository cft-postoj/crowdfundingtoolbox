<?php

namespace Modules\Payment\Console;

use Illuminate\Console\Command;
use Modules\Payment\Entities\Donation;
use Modules\Payment\Entities\Payment;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class AddTransactionDateToDonations extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'donation-transaction-date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copy transaction dates from payments to donations.';

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
//        $payments = Payment::all();
//        foreach ($payments as $payment) {
//            Donation::where('payment_id', $payment->id)
//                ->update([
//                    'trans_date' => $payment->transaction_date
//                ]);
//        }
        $donations = Donation::whereNotNull('payment_id')->where('trans_date', null)->get();
        foreach ($donations as $donation) {
            $payment = Payment::where('id', $donation->payment_id)->first();
            Donation::where('id', $donation->id)->update([
                'trans_date' => $payment->transaction_date
            ]);
        }
    }

}
