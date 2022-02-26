<?php

namespace App\Support;

use Carbon\Carbon;

class FeedEntry
{
    public function __construct(
        public string $title,
        public string $link,
        public string $summary,
        public Carbon $updated,
    )
    {

    }
}
