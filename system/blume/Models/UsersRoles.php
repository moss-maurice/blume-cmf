<?php

namespace Blume\Models;

use Blume\Models\Roles;
use Illuminate\Database\Eloquent\Model;

class UsersRoles extends Model
{
    protected $fillable = [
        'model_type',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (config('permission.teams')) {
            $this->mergeFillable([
                config('permission.column_names.team_foreign_key') ?? 'team_id',
            ]);
        }

        $this->mergeFillable([
            config('permission.column_names.role_pivot_key') ?? 'role_id',
            config('permission.column_names.model_morph_key') ?? 'model_id',
        ]);
    }

    public function getTable()
    {
        $this->table = config('permission.table_names.model_has_roles');

        return parent::getTable();
    }

    public function role()
    {
        return $this->hasOne(Roles::class, 'id', config('permission.column_names.role_pivot_key') ?? 'role_id');
    }
}
