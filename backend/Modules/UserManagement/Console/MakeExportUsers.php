<?php

namespace Modules\UserManagement\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Queue;
use Modules\UserManagement\Entities\PortalUser;
use Modules\UserManagement\Jobs\MakeExportUserRecord;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MakeExportUsers extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'aggregate:export-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make aggregate table for users export csv.';

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
        $users = PortalUser::all();
        $delay = 300;
        foreach ($users as $key => $user) {
            if ($key % 20 === 0) {
                $delay = $delay + 1;
            }
            Queue::later($delay, new MakeExportUserRecord($user->id));
        }
//        $record = new MakeExportUserRecord(PortalUser::first()->id);
//        $record->handle();
        //new MakeExportUserRecord(PortalUser::first()->id);
        //Queue::later(30, new MakeExportUserRecord(PortalUser::first()->id));
    }
}
