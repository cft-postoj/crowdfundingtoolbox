<?php

namespace Modules\Targeting\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\Queue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Targeting\Services\AggregateTargetingService;

class MakeTargetingData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $min;
    private $max;
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
        $s = new AggregateTargetingService();
        $s->doUserJob($this->portal_user_id);
    }
}
