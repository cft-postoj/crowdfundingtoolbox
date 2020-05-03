<?php

namespace Modules\UserManagement\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\UserManagement\Entities\GeneratedUserToken;
use Modules\UserManagement\Repositories\GeneratedUserTokenRepository;

class RemoveGeneratedToken implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $generatedUserToken;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->generatedUserToken = new GeneratedUserToken();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(GeneratedUserTokenRepository $generatedUserTokenRepository)
    {
        $id = $this->generatedUserToken['id'];
        $generatedUserTokenRepository->delete($id);
    }
}
