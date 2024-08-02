<?php

namespace Blume\Models;

use Blume\Models\Permissions;
use Blume\Models\Roles;
use Illuminate\Database\Eloquent\Model;

class RolesPermissions extends Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->mergeFillable([
            config('permission.column_names.permission_pivot_key') ?? 'permission_id',
            config('permission.column_names.role_pivot_key') ?? 'role_id',
        ]);
    }

    public function getTable()
    {
        $this->table = config('permission.table_names.role_has_permissions');

        return parent::getTable();
    }

    public function permission()
    {
        return $this->hasOne(Permissions::class, 'id', config('permission.column_names.permission_pivot_key') ?? 'permission_id');
    }

    public function role()
    {
        return $this->hasOne(Roles::class, 'id', config('permission.column_names.role_pivot_key') ?? 'role_id');
    }
}
