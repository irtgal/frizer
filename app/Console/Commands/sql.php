<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\DB;

use Illuminate\Console\Command;

class sql extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sql {type} {query}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute sql query';

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
     * @return int
     */
    public function handle()
    {
        $query = $this->argument('query');
        $type = $this->argument('type');
        try {
            $this->comment(json_encode(DB::$type($query)));
            $this->info('Query executed successfuly');
        } catch (\Exception $e) {
            $this->error($e);
        }
    }
}
