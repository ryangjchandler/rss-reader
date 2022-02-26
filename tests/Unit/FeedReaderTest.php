<?php

use App\Support\FeedEntry;
use App\Support\FeedReader;
use Illuminate\Support\Collection;
use Tests\TestCase;

function reader(): FeedReader
{
    return new FeedReader('https://ryangjchandler.co.uk/feed');
}

uses(TestCase::class);

it('can be created', function () {
    expect(reader())
        ->toBeInstanceOf(FeedReader::class);
});

it('can read the feed', function () {
    $reader = reader();

    expect($reader->read())
        ->loaded()->toBeTrue();
});

it('can read entries', function () {
    $reader = reader();

    expect($reader->read()->entries())
        ->toBeInstanceOf(Collection::class)
        ->first()->toBeInstanceOf(FeedEntry::class);
});
