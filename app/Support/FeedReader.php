<?php

namespace App\Support;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Orchestra\Parser\Xml\Document;
use Orchestra\Parser\Xml\Facade as Xml;

class FeedReader
{
    protected ?Document $document = null;

    public function __construct(
        protected string $url,
    ) {}

    public function read(): static
    {
        if ($this->loaded()) {
            return $this;
        }

        $this->document = Xml::load($this->url);

        return $this;
    }

    public function entries(): Collection
    {
        $entries = $this->document->parse([
            'entries' => [
                'uses' => 'entry[title,link::href>link,summary,updated]',
            ]
        ]);

        return collect($entries['entries'])->map(fn (array $entry) => new FeedEntry(...[
            ...$entry,
            'updated' => Carbon::parse($entry['updated']),
        ]));
    }

    public function loaded(): bool
    {
        return $this->document !== null;
    }
}
