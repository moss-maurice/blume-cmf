<?php

namespace Blume\Models;

use Blume\Models\Events;
use Blume\Models\Plugins;
use Illuminate\Database\Eloquent\Model;

class EventsListeners extends Model
{
    protected $fillable = [
        'event_id',
        'handler',
    ];

    public function event()
    {
        return $this->hasOne(Events::class, 'id', 'event_id');
    }
}
