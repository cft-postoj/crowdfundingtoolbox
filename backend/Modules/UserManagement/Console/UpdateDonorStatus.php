<?php

namespace Modules\UserManagement\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Modules\UserManagement\Entities\PortalUserDonorCategory;
use Modules\UserManagement\Services\PortalUserDonorCategoryService;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class UpdateDonorStatus extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'donors:update-category-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update donors category.';
    private $portalUserDonorCategoryService;

    /**
     * Create a new command instance.
     *
     * @param PortalUserDonorCategoryService $portalUserDonorCategoryService
     */
    public function __construct(PortalUserDonorCategoryService $portalUserDonorCategoryService)
    {
        parent::__construct();
        $this->portalUserDonorCategoryService = $portalUserDonorCategoryService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::info('Execution of command ' . $this->name . ' started.');
        $this->portalUserDonorCategoryService->updatePortalUserCategoryAll();
        Log::info('Execution of command ' . $this->name . ' succesfully finished.');

    }

}
