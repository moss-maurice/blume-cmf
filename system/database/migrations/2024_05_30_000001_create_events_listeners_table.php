<?php

use Blume\Models\EventsListeners;
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
        if (!Schema::hasTable((new EventsListeners)->getTable())) {
            Schema::create((new EventsListeners)->getTable(), function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('event_id');
                $table->string('handler');
                $table->timestamps();

                $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
                $table->unique(['event_id', 'handler'], (new EventsListeners)->getTable() . '_unique');
            });
        };
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists((new EventsListeners)->getTable());
    }
};
