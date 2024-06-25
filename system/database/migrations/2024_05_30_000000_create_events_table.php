<?php

use Blume\Models\Events;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable((new Events)->getTable())) {
            Schema::create((new Events)->getTable(), function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('handler');
                $table->timestamps();

                $table->unique(['name'], (new Events)->getTable() . '_unique');
            });
        };
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists((new Events)->getTable());
    }
};
