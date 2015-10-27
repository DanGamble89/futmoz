<?php

namespace App\Console\Commands;

use App\Downloader;
use Illuminate\Console\Command;

class PullNations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pull:nations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Pull nation data from EA's JSON and create nations";

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
        $downloader = new Downloader();

        var_dump($downloader->buildNations());
    }
}
