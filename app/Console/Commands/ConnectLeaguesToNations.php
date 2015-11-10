<?php

namespace App\Console\Commands;

use App\Downloader;
use App\Models\League;
use App\Models\Nation;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class ConnectLeaguesToNations extends Command
{
    protected $signature = 'connect:l2n';
    protected $description = "Add foreign key constraints to Leagues & Nations";

    public function __construct()
    {
        parent::__construct();

        $this->client = new Client();
        $this->url = 'http://cdn.content.easports.com/fifa/fltOnlineAssets/B488919F-23B5-497F-9FC0-CACFB38863D0/2016/fut/items/web/leagues.json';
    }

    public function handle()
    {
        $res = $this->client->request('GET', $this->url);
        $json = json_decode($res->getBody());

        foreach ($json->Leagues->League as $key => $item) {
            echo "{$item->LeagueId}, {$item->NationId} \n";
            $league = League::where('ea_id', $item->LeagueId)->first();
            $nation = Nation::where('ea_id', $item->NationId)->first();

            if ($league) {
                $nation->leagues()->save($league);
            }
        }
    }
}
