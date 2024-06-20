<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class XboardUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xboard:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'xboard update';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Please wait while the database is being imported...');
            \Artisan::call("migrate");
            $this->info(\Artisan::output());
        \Artisan::call('horizon:terminate');
        $this->info('The update is complete, the queue service has been restarted and you dont need to do anything.');
    }
}
