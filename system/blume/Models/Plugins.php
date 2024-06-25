<?php

namespace Blume\Models;

use Illuminate\Database\Eloquent\Model;

class Plugins extends Model
{
    protected $fillable = [
        'name',
        'handler',
        'active',
    ];

    protected $attributes = [
        'active' => false,
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function isInstalled(): bool
    {
        return !is_null($this->id) ? true : false;
    }
}
