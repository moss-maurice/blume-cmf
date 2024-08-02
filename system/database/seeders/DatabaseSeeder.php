<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\EventsSeeder;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\PluginsSeeder;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //$this->call(PermissionsSeeder::class);
        //$this->call(PluginsSeeder::class);
        //$this->call(EventsSeeder::class);

        // \Blume\Models\Users::factory(10)->create();

        // \Blume\Models\Users::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
