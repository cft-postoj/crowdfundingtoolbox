<?php

namespace Modules\Statistics\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Statistics\Entities\AggArticleStats;
use Modules\Statistics\Repositories\GeneralStatsRepository;
use Modules\UserManagement\Entities\TrackingVisit;

class MakeArticleStatsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $article_id;
    private $general_stats_repo;

    /**
     * Create a new job instance.
     * @param $article_id
     * @param GeneralStatsRepository $generalStatsRepository
     * @return void
     */
    public function __construct($article_id)
    {
        $this->article_id = $article_id;
        $this->general_stats_repo = new GeneralStatsRepository();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $articleData = $this->general_stats_repo->makeAggArticleStats($this->article_id);
        $tVisit = TrackingVisit::where('article_id', $this->article_id)->orderBy('id', 'DESC')->first();
        $aggArticleStats = AggArticleStats::where('id', $this->article_id)->first();

        if ($aggArticleStats) {
            // Update
            $aggArticleStats->title = $articleData->title;
            $aggArticleStats->url = $articleData->url;
            $aggArticleStats->visits = ($articleData->visits !== null) ? $articleData->visits : 0;
            $aggArticleStats->amount_sum = ($articleData->amount_sum !== null) ? $articleData->amount_sum : 0;
            $aggArticleStats->new_users = ($articleData->new_users !== null) ? $articleData->new_users : 0;
            $aggArticleStats->updated_at = $tVisit->updated_at;
            $aggArticleStats->update();
        } else {
            // Create
            AggArticleStats::create([
                'article_id' => $this->article_id,
                'title' => $articleData->title,
                'url' => $articleData->url,
                'visits' => ($articleData->visits !== null) ? $articleData->visits : 0,
                'amount_sum' => ($articleData->amount_sum !== null) ? $articleData->amount_sum : 0,
                'new_users' => ($articleData->new_users !== null) ? $articleData->new_users : 0,
                'created_at' => $tVisit->updated_at,
                'updated_at' => $tVisit->updated_at
            ]);
        }
    }
}
