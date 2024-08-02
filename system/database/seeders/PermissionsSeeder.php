<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    protected $permissions = [
        'create post' => [
            'admin', 'editor',
        ],
        'read post' => [
            'admin', 'editor', 'user',
        ],
        'edit post' => [
            'admin', 'editor',
        ],
        'delete post' => [
            'admin', 'editor',
        ],
        'publish post' => [
            'admin', 'editor',
        ],
        'unpublish post' => [
            'admin', 'editor',
        ],
    ];

    public function run()
    {
        collect($this->permissions)->keys()
            ->each(function ($permission) {
                Permission::create([
                    'name' => $permission,
                    'protected' => true,
                ]);
            });

        collect($this->permissions)->flatten()
            ->unique()
            ->values()
            ->each(function ($role) {
                $rolePermissions = collect($this->permissions)->filter(function ($roles) use ($role) {
                    return in_array($role, $roles, true);
                })
                    ->keys();

                Role::create([
                    'name' => $role,
                    'protected' => true,
                ])
                    ->givePermissionTo($rolePermissions->all());
            });
    }
}
