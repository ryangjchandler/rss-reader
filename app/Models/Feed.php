<?php

namespace App\Models;

use App\Support\FeedEntry;
use App\Support\FeedReader;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'last_processed_at' => 'datetime',
    ];

    public function entries()
    {
        return $this->hasMany(Entry::class);
    }

    public function process(): bool
    {
        $reader = FeedReader::make($this->url)->read();

        if ($reader->updated()->isBefore($this->last_processed_at)) {
            return false;
        }

        $reader->entries()->each(function (FeedEntry $entry) {
            $this->entries()->updateOrCreate([
                'feed_entry_id' => $entry->id,
            ], [
                'title' => $entry->title,
                'summary' => $entry->summary,
                'link' => $entry->link,
            ]);
        });

        return true;
    }
}
