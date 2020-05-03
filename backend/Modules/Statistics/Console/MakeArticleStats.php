<?php

namespace Modules\Statistics\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Queue;
use Modules\Campaigns\Entities\Article;
use Modules\Statistics\Jobs\MakeArticleStatsJob;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MakeArticleStats extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'agg:article-stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make aggregate table of article stats.';

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
        $articles = Article::where('id', '>', 0)->where('id', '<', 1000)->get();
        $delay = 300;
        foreach ($articles as $key => $article) {
            if ($key % 5 === 0) {
                $delay = $delay + 1;
            }
//            $job = new MakeArticleStatsJob($article->id);
//            $job->handle();
            Queue::later($delay, new MakeArticleStatsJob($article->id));
        }
    }
}
