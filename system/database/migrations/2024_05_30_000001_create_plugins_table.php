<?php

use Blume\Models\Plugins;
use Database\Seeders\PluginsSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable((new Plugins)->getTable())) {
            Schema::create((new Plugins)->getTable(), function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('handler');
                $table->boolean('active')->default(false);
                $table->timestamps();

                $table->unique(['name'], (new Plugins)->getTable() . '_unique');
            });
        }

        Artisan::call('db:seed', [
            '--class' => PluginsSeeder::class,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists((new Plugins)->getTable());
    }
};
