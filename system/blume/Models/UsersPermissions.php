<?php

namespace Blume\Models;

use Blume\Models\Permissions;
use Illuminate\Database\Eloquent\Model;

class UsersPermissions extends Model
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
            config('permission.column_names.permission_pivot_key') ?? 'permission_id',
            config('permission.column_names.model_morph_key') ?? 'model_id',
        ]);
    }

    public function getTable()
    {
        $this->table = config('permission.table_names.model_has_permissions');

        return parent::getTable();
    }

    public function permission()
    {
        return $this->hasOne(Permissions::class, 'id', config('permission.column_names.permission_pivot_key') ?? 'permission_id');
    }
}
