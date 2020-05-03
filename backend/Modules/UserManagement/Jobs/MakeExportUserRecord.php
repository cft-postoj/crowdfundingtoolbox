<?php

namespace Modules\UserManagement\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\UserManagement\Exports\DonorsExport;

class MakeExportUserRecord implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $portal_user_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($portal_user_id)
    {
        $this->portal_user_id = $portal_user_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $export = new DonorsExport();
        $export->makeExportUserRecord($this->portal_user_id);
    }
}
