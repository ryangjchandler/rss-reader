<?php

namespace App\Console\Commands;

use App\Jobs\ProcessFeed;
use App\Models\Feed;
use Illuminate\Console\Command;

class ProcessFeedsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:process-feeds';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process all created feeds.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Feed::lazy()
            ->each(function (Feed $feed) {
                $this->info('Dispatching processor for feed ' . $feed->getKey() . '.');

                dispatch(new ProcessFeed($feed));
            });

        return 0;
    }
}
