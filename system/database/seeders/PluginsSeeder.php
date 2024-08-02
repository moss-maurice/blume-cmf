<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PluginsSeeder extends Seeder
{
    public function run()
    {
        $plugins = blume()->plugins()->notInstalledPlugins();

        if ($plugins->isNotEmpty()) {
            $plugins->each(function ($plugin) {
                blume()->plugins()->installPlugin($plugin->name);
            });
        }
    }
}
