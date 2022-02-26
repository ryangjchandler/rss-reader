<?php

use App\Console\Commands\ProcessFeedsCommand;
use App\Jobs\ProcessFeed;
use App\Models\Feed;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Queue;

use function Pest\Laravel\artisan;

it('dispatches process feed jobs for each feed', function () {
    Feed::create([
        'name' => 'foo',
        'url' => 'https://ryangjchandler.co.uk/feed',
    ]);

    Queue::fake();

    artisan(ProcessFeedsCommand::class)
        ->assertSuccessful();

    Queue::assertPushed(ProcessFeed::class);
});
