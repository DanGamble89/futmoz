<?php

namespace App\Console\Commands;

use App\Downloader;
use Illuminate\Console\Command;

class PullPlayers extends Command
{
    protected $signature = 'pull:players';
    protected $description = "Pull player data from EA's JSON and create players";

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $downloader = new Downloader();

        $downloader->buildPlayers();

        $this->info('Players pulled');
    }
}
