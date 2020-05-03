<?php

namespace Modules\Payment\Console;

use Illuminate\Console\Command;
use Modules\Payment\Services\CardPayService;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ValidateCardpayPayments extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'payments:cardpay-validate-payments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for get all payments from previous day and check, if they are exist in our database.';

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
        $cardPayService = new CardPayService();
        $cardPayService->validatePayments();
    }
}
