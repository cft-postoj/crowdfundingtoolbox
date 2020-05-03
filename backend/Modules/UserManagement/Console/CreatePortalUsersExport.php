<?php

namespace Modules\UserManagement\Console;

use Illuminate\Console\Command;
use Modules\UserManagement\Exports\DonorsExport;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CreatePortalUsersExport extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'users-export:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add portal user export to cache.';

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
        $userExport = new DonorsExport();
        $userExport->usersExportJob();
    }
}
