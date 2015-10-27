<?php

namespace App\Console\Commands;

use App\Downloader;
use Illuminate\Console\Command;

class PullClubs extends Command
{
    protected $signature = 'pull:clubs';
    protected $description = "Pull club data from EA's JSON and create clubs";

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $downloader = new Downloader();

        $downloader->buildClubs();

        $this->info('Clubs pulled');
    }
}
