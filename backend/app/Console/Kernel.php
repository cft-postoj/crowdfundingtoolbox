<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'Modules\UserManagement\Console\UpdateDonorStatus',
        'App\Console\Commands\testExecution',
        'Modules\UserManagement\Console\SendRegistrationMailDuringDonation',
        'Modules\Payment\Console\DonationsCalcMonthlyStatus',
        'Modules\Payment\Console\BulkPairUnpairedPayments',
        'Modules\Payment\Console\DonationsCalcMonthlyStatus',
        'Modules\Payment\Console\CalculateReferralWidgets',
        'Modules\UserManagement\Console\CreatePortalUsersExport',
        'Modules\Payment\Console\CalculateReferralTrackingShow',
        'Modules\Payment\Console\DeleteDonationWithDuplicityPaymentId',
        'Modules\Targeting\Console\MakeTargetingData',
        'Modules\Payment\Console\AddTransactionDateToDonations',
        'Modules\Targeting\Console\AggTargetingUpdate',
        'Modules\UserManagement\Console\MakeExportUsers',
        'Modules\Payment\Console\CardpayPairingFix',
        'Modules\Statistics\Console\MakeArticleStats',
        'Modules\Payment\Console\ValidateCardpayPayments',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // just to test execution of schedule
//        $schedule->command('command:testExecution')->everyMinute();

        $schedule->command('mail:send-donation-reg')->everyMinute();

        foreach (['1', '10', '20'] as $day) {
            $schedule->command('donors:update-category-all')->monthlyOn($day);
        }
        foreach (['05:00', '11:00', '18:00'] as $time) {
            $schedule->command('payments:import-bmail')->dailyAt($time);
        }

        $schedule->command('queue:work --tries=3')->everyMinute(); // 3 attempts for queue

        // job for validate cardpay payments (every night)
        $schedule->command('payments:cardpay-validate-payments')->dailyAt('1:30');

        // add job for targeting data (every night)
        $schedule->command('agg:targeting-update')->dailyAt('2:00');
        // add job for users export data (every night)
        $schedule->command('agg:export-users')->dailyAt('3:00');

        // export users
        $schedule->command('users-export:cache')->twiceDaily(7, 20);
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
