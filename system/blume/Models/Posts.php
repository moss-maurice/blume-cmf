<?php

namespace Blume\Models;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    protected $fillable = [
        'title',
        'body',
    ];
}
