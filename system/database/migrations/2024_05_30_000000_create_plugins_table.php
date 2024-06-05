<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Lacora\Models\Plugins;

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
                $table->string('class');
                $table->boolean('active')->default(false);
                $table->timestamps();
            });
        }
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
