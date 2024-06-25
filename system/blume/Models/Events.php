<?php

namespace Blume\Models;

use Blume\Models\EventsListeners;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    protected $fillable = [
        'name',
        'handler',
    ];

    public function listeners()
    {
        return $this->hasMany(EventsListeners::class, 'event_id', 'id');
    }
}
