<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use RyanChandler\Uuid\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Entry extends Model
{
    use HasFactory;
    use HasUuid;

    protected $guarded = [];

    public function feed()
    {
        return $this->belongsTo(Feed::class);
    }
}
