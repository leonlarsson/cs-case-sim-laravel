<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateFreshAndSeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:migrate-fresh-and-seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Does a migrate:fresh and then seeds the database for development purposes.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->confirm('This will delete all data in the database. Do you wish to continue?')) {
            $this->call('migrate:fresh');
            $this->call('db:seed');
            $this->call('db:seed', ['--class' => 'UnboxSeeder']);

            $this->info('Database has been refreshed and seeded.');
        }
    }
}
