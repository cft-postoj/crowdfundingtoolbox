<?php

namespace Modules\Targeting\Console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Modules\Targeting\Entities\AggregateTargeting;
use Modules\Targeting\Services\AggregateTargetingService;
use Modules\UserManagement\Entities\PortalUser;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MakeTargetingData extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'aggregate:targeting';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make aggregate table from user records.';

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
//        $users = PortalUser::all();
//        foreach ($users as $user) {
//            Queue::later(30, new \Modules\Targeting\Jobs\MakeTargetingData($user->id));
//        }
        $users = AggregateTargeting::where('is_supporter', false)->whereNotNull('last_donation_id')->get();
        foreach ($users as $user) {
            Queue::later(30, new \Modules\Targeting\Jobs\MakeTargetingData($user->portal_user_id));
        }
    }
}
