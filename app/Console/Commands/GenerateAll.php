<?php

namespace App\Console\Commands;

use Artisan;
use Illuminate\Console\Command;

class GenerateAll extends Command
{
    protected $signature = 'generate:all {name}';

    protected $description = 'Generate Model, Controller, Migration, and Resource';

    public function handle()
    {
        $name = $this->argument('name');

        Artisan::call('make:model', ['name' => $name]);
        Artisan::call('make:controller', ['name' => $name . 'Controller', '--resource' => true]);
        Artisan::call('make:migration', ['name' => 'create_' . strtolower($name) . '_table']);
        Artisan::call('make:resource', ['name' => $name . 'Resource']);

        $this->info('Model, Controller, Migration, and Resource generated successfully.');
    }
}
