<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TriggerHerbalMigration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:herbal-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch the background job to migrate legacy herbal data into the new medicines tables';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Dispatching MigrateHerbalDataJob to the queue...');
        
        \App\Jobs\MigrateHerbalDataJob::dispatch();
        
        $this->info('Job dispatched successfully! Make sure your queue worker is running (php artisan queue:work).');
    }
}
