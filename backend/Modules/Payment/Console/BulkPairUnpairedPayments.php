<?php

namespace Modules\Payment\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Modules\Payment\Services\PaymentService;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class BulkPairUnpairedPayments extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'unpaired-payments:try-pair';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Try pair all unpaired payments (via Variable symbol or IBAN).';

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
     * @param PaymentService $paymentService
     * @return mixed
     */
    public function handle(PaymentService $paymentService)
    {
        Log::info('Execution of command ' . $this->name);
        $paymentService->bulkPairUnpairedPayments();
        Log::info('Execution of command ' . $this->name . ' succesfully finished.');
    }
}
