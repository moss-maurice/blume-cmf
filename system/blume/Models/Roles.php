<?php

namespace Blume\Models;

use Spatie\Permission\Models\Role;

class Roles extends Role
{
    protected $fillable = [
        'name',
        'guard_name',
        'protected',
    ];

    protected $casts = [
        'protected' => 'boolean',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (config('permission.teams') || config('permission.testing')) {
            $this->mergeFillable([
                config('permission.column_names.team_foreign_key') ?? 'team_id',
            ]);
        }
    }

    public function getTable()
    {
        $this->table = config('permission.table_names.roles');

        return parent::getTable();
    }
}
