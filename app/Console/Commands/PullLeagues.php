<?php

namespace App\Console\Commands;

use App\Downloader;
use Illuminate\Console\Command;

class PullLeagues extends Command
{
    protected $signature = 'pull:leagues';
    protected $description = "Pull league data from EA's JSON and create leagues";

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $downloader = new Downloader();

        $downloader->buildLeagues();

        $this->info('Leagues pulled');
    }
}
