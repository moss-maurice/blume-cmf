<?php

use Blume\Models\Permissions;
use Blume\Models\Roles;
use Blume\Models\RolesPermissions;
use Blume\Models\UsersPermissions;
use Blume\Models\UsersRoles;
use Database\Seeders\PermissionsSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (empty(config('permission.table_names'))) {
            throw new Exception('Error: config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }

        if (config('permission.teams') && empty(config('permission.column_names.team_foreign_key') ?? 'team_id' ?? null)) {
            throw new Exception('Error: team_foreign_key on config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }

        if (!Schema::hasTable((new Permissions)->getTable())) {
            Schema::create((new Permissions)->getTable(), function (Blueprint $table) {
                //$table->engine('InnoDB');

                // permission id
                $table->bigIncrements('id');

                // For MyISAM use string('name', 225); // (or 166 for InnoDB with Redundant/Compact row format)
                $table->string('name');

                // For MyISAM use string('guard_name', 25);
                $table->string('guard_name');

                $table->boolean('protected')->nullable()->default(false);

                $table->timestamps();

                $table->unique([
                    'name',
                    'guard_name',
                ]);
            });
        }

        if (!Schema::hasTable((new Roles)->getTable())) {
            Schema::create((new Roles)->getTable(), function (Blueprint $table) {
                //$table->engine('InnoDB');

                // role id
                $table->bigIncrements('id');

                // permission.testing is a fix for sqlite testing
                if (config('permission.teams') || config('permission.testing')) {
                    $table->unsignedBigInteger(config('permission.column_names.team_foreign_key') ?? 'team_id')->nullable();

                    $table->index(config('permission.column_names.team_foreign_key') ?? 'team_id', 'roles_team_foreign_key_index');
                }

                // For MyISAM use string('name', 225); // (or 166 for InnoDB with Redundant/Compact row format)
                $table->string('name');

                // For MyISAM use string('guard_name', 25);
                $table->string('guard_name');

                $table->boolean('protected')->nullable()->default(false);

                $table->timestamps();

                if (config('permission.teams') || config('permission.testing')) {
                    $table->unique([
                        config('permission.column_names.team_foreign_key') ?? 'team_id',
                        'name',
                        'guard_name',
                    ]);
                } else {
                    $table->unique([
                        'name',
                        'guard_name',
                    ]);
                }
            });
        }

        if (!Schema::hasTable((new UsersPermissions)->getTable())) {
            Schema::create((new UsersPermissions)->getTable(), function (Blueprint $table) {
                $table->unsignedBigInteger(config('permission.column_names.permission_pivot_key') ?? 'permission_id');
                $table->string('model_type');
                $table->unsignedBigInteger(config('permission.column_names.model_morph_key') ?? 'model_id');
                $table->index([config('permission.column_names.model_morph_key') ?? 'model_id', 'model_type'], 'model_has_permissions_model_id_model_type_index');

                $table->foreign(config('permission.column_names.permission_pivot_key') ?? 'permission_id')
                    ->references('id') // permission id
                    ->on((new Permissions)->getTable())
                    ->onDelete('cascade');

                if (config('permission.teams')) {
                    $table->unsignedBigInteger(config('permission.column_names.team_foreign_key') ?? 'team_id');
                    $table->index(config('permission.column_names.team_foreign_key') ?? 'team_id', 'model_has_permissions_team_foreign_key_index');

                    $table->primary(
                        [
                            config('permission.column_names.team_foreign_key') ?? 'team_id',
                            config('permission.column_names.permission_pivot_key') ?? 'permission_id',
                            config('permission.column_names.model_morph_key') ?? 'model_id',
                            'model_type'
                        ],
                        'model_has_permissions_permission_model_type_primary'
                    );
                } else {
                    $table->primary(
                        [
                            config('permission.column_names.permission_pivot_key') ?? 'permission_id',
                            config('permission.column_names.model_morph_key') ?? 'model_id',
                            'model_type'
                        ],
                        'model_has_permissions_permission_model_type_primary'
                    );
                }
            });
        }

        if (!Schema::hasTable((new UsersRoles)->getTable())) {
            Schema::create((new UsersRoles)->getTable(), function (Blueprint $table) {
                $table->unsignedBigInteger(config('permission.column_names.role_pivot_key') ?? 'role_id');
                $table->string('model_type');
                $table->unsignedBigInteger(config('permission.column_names.model_morph_key') ?? 'model_id');
                $table->index([config('permission.column_names.model_morph_key') ?? 'model_id', 'model_type'], 'model_has_roles_model_id_model_type_index');

                $table->foreign(config('permission.column_names.role_pivot_key') ?? 'role_id')
                    ->references('id') // role id
                    ->on((new Roles)->getTable())
                    ->onDelete('cascade');

                if (config('permission.teams')) {
                    $table->unsignedBigInteger(config('permission.column_names.team_foreign_key') ?? 'team_id');
                    $table->index(config('permission.column_names.team_foreign_key') ?? 'team_id', 'model_has_roles_team_foreign_key_index');

                    $table->primary(
                        [
                            config('permission.column_names.team_foreign_key') ?? 'team_id',
                            config('permission.column_names.role_pivot_key') ?? 'role_id',
                            config('permission.column_names.model_morph_key') ?? 'model_id',
                            'model_type',
                        ],
                        'model_has_roles_role_model_type_primary'
                    );
                } else {
                    $table->primary(
                        [
                            config('permission.column_names.role_pivot_key') ?? 'role_id',
                            config('permission.column_names.model_morph_key') ?? 'model_id',
                            'model_type',
                        ],
                        'model_has_roles_role_model_type_primary'
                    );
                }
            });
        }

        if (!Schema::hasTable((new RolesPermissions)->getTable())) {
            Schema::create((new RolesPermissions)->getTable(), function (Blueprint $table) {
                $table->unsignedBigInteger(config('permission.column_names.permission_pivot_key') ?? 'permission_id');
                $table->unsignedBigInteger(config('permission.column_names.role_pivot_key') ?? 'role_id');

                $table->foreign(config('permission.column_names.permission_pivot_key') ?? 'permission_id')
                    ->references('id') // permission id
                    ->on((new Permissions)->getTable())
                    ->onDelete('cascade');

                $table->foreign(config('permission.column_names.role_pivot_key') ?? 'role_id')
                    ->references('id') // role id
                    ->on((new Roles)->getTable())
                    ->onDelete('cascade');

                $table->primary([
                    config('permission.column_names.permission_pivot_key') ?? 'permission_id',
                    config('permission.column_names.role_pivot_key') ?? 'role_id',
                ], 'role_has_permissions_permission_id_role_id_primary');
            });
        }

        Artisan::call('db:seed', [
            '--class' => PermissionsSeeder::class,
        ]);

        app('cache')
            ->store(config('permission.cache.store') != 'default' ? config('permission.cache.store') : null)
            ->forget(config('permission.cache.key'));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (empty(config('permission.table_names'))) {
            throw new Exception('Error: config/permission.php not found and defaults could not be merged. Please publish the package configuration before proceeding, or drop the tables manually.');
        }

        Schema::dropIfExists((new RolesPermissions)->getTable());
        Schema::dropIfExists((new UsersRoles)->getTable());
        Schema::dropIfExists((new UsersPermissions)->getTable());
        Schema::dropIfExists((new Roles)->getTable());
        Schema::dropIfExists((new Permissions)->getTable());
    }
};
