<?php

namespace Modules\Payment\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Modules\Payment\Services\PaymentService;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ImportPaymentsBmail extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments:import-bmail {--since= : Number of days, from when b-mails should be parsed}
     {--before= : Number of days, to when bmails should be parsed}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import payments from Bmail.';

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
    public function handle(PaymentService $paymentService)
    {
        $sinceOption = $this->option('since');
        $beforeOption = $this->option('before');
        $sinceDays = $sinceOption !== null ? (int)$sinceOption : 0;
        $beforeDays = $beforeOption !== null ? (int)$sinceOption : 0;

        Log::info('Execution of command ' . $this->name . ' started with options: ' . http_build_query($this->options()) );
        $paymentService->getPaymentsFromBmail($sinceDays, $beforeDays);
        Log::info('Execution of command ' . $this->name . ' succesfully finished.');
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
