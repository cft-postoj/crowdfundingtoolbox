<?php

namespace Modules\Targeting\Console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Queue;
use Modules\Payment\Entities\Donation;
use Modules\UserManagement\Entities\PortalUser;
use Modules\UserManagement\Entities\TrackingVisit;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class AggTargetingUpdate extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'agg:targeting-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update of aggregate targeting table. Every night script get all data for previous day and update targeting table.';

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
        // get all new/updated portal_users to custom array
        $portal_user_ids = array();

        $portalUsers = PortalUser::whereDate('updated_at', '>', Carbon::now()->subHours(24))->get();
        foreach ($portalUsers as $portalUser) {
            array_push($portal_user_ids, $portalUser->id);
        }

        $donations = Donation::whereDate('updated_at', '>', Carbon::now()->subHours(24))->whereNotNull('payment_id')->get();
        foreach ($donations as $donation) {
            if (!in_array($donation->portal_user_id, $portal_user_ids)) {
                array_push($portal_user_ids, $donation->portal_user_id);
            }
        }

        $visits = TrackingVisit::whereDate('updated_at', '>', Carbon::now()->subHours(24))->whereNotNull('portal_user_id')->get();
        foreach ($visits as $visit) {
            if (!in_array($visit->portal_user_id, $portal_user_ids)) {
                array_push($portal_user_ids, $visit->portal_user_id);
            }
        }

        // cycle with portal user ids
        foreach ($portal_user_ids as $portal_user_id) {
            Queue::later(30, new \Modules\Targeting\Jobs\MakeTargetingData($portal_user_id));
        }

    }

}
