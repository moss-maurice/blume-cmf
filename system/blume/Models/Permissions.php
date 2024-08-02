<?php

namespace Blume\Models;

use Spatie\Permission\Models\Permission;

class Permissions extends Permission
{
    protected $fillable = [
        'name',
        'guard_name',
        'protected',
    ];

    protected $casts = [
        'protected' => 'boolean',
    ];

    public function getTable()
    {
        $this->table = config('permission.table_names.permissions');

        return parent::getTable();
    }
}
