<?php

namespace Modules\UserManagement\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Modules\UserManagement\Emails\DonationEmail;
use Modules\UserManagement\Services\CreatedUsersService;
use Modules\UserManagement\Services\GeneratedUserTokenService;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SendRegistrationMailDuringDonation extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'mail:send-donation-reg';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send registration mail to all users, who was in second step but did not proceed to 3 step.
    After sending, mark CreatedUser as deleted.';

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
    public function handle(CreatedUsersService $createdUsersService)
    {
        $createdUsers = $createdUsersService->getAllWhereMailShouldBeSent();
        $createdUsers->each(function ($item, $key) use ($createdUsersService) {
            $generatedTokenService = new GeneratedUserTokenService();
            $generatedToken = $generatedTokenService->create($item->portalUser->user->id);
            Log::info('SEND REGISTRATION EMAIL JOB STARTED --- ' . $item->portalUser->user->email . ' ID - ' . $item->portalUser->user->id);
            $trackingShowIsNull = $item->trackingShow !== null;
            $trackingShowDonationIsNull = $trackingShowIsNull ? $item->trackingShow->donation !== null : false;
            if ($trackingShowIsNull && $trackingShowDonationIsNull) {
                Mail::to($item->portalUser->user->email)->send(
                    new DonationEmail($item->trackingShow->donation->amount, $item->portalUser->variableSymbol->variable_symbol, null, 'donation',
                        $item->trackingShow->donation->is_monthly_donation ? 'monthly' : 'one-time' , 1, $generatedToken, $item->portalUser->user->id));
                $createdUsersService->markAsSent($item->id);
            } else {
                Log::info('Unable to send mail because one of this assertion is false - trackingShowIsNull = ' .
                    ($trackingShowIsNull ? 'true' : 'false') .' and trackingShowDonationIsNull = ' .
                    ($trackingShowDonationIsNull  ? 'true' : 'false') . '.' );
                $item->delete();
            }
        });
    }

}
