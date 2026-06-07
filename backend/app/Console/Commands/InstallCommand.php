<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class InstallCommand extends Command
{
    protected $signature = 'app:install';
    protected $description = 'Run initial setup for the Ads platform';

    public function handle()
    {
        $this->info('Running migrations...');
        Artisan::call('migrate', ['--force' => true]);
        $this->info('Seeding database...');
        Artisan::call('db:seed', ['--force' => true]);
        $this->info('Installation complete.');
    }
}
