<?php

namespace App;

use App\Models\Club;
use App\Models\League;
use App\Models\Nation;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Promise;

class Downloader
{
    public $url = 'https://www.easports.com/uk/fifa/ultimate-team/api/fut/item?jsonParamObject=%7B%22page%22:1%7D';

    public function __construct()
    {
        $this->client = new Client();
    }

    private function getTotalPages()
    {
        try {
            $res = $this->client->request('GET', $this->url);
        } catch (ClientException $e) {
            var_dump($e->getResponse());
        }
        $json = json_decode($res->getBody());

        return $json->totalPages;
    }

    private function getNationData()
    {
        $totalPages = $this->getTotalPages();
        $data = [];

        for ($i = 1; $i <= $totalPages; $i++) {
            $res = $this->client->get("https://www.easports.com/uk/fifa/ultimate-team/api/fut/item?jsonParamObject=%7B%22page%22:{$i}%7D");
            $json = json_decode($res->getBody());

            echo "Got page {$i}/{$totalPages}\r\n";

            foreach ($json->items as $key => $item) {
                $nation = $item->nation;
                $nationData = [
                    'name'       => $nation->name,
                    'slug'       => $nation->name,
                    'name_abbr'  => $nation->abbrName,
                    'ea_id'      => $nation->id,
                    'img'        => $nation->imgUrl,
                    'img_small'  => $nation->imageUrls->small,
                    'img_medium' => $nation->imageUrls->medium,
                    'img_large'  => $nation->imageUrls->large,
                ];

                if (!in_array($nationData, $data, true)) {
                    array_push($data, $nationData);
                }
            }
        }

        return $data;
    }

    public function buildNations()
    {
        $nations = $this->getNationData();

        foreach ($nations as $nation) {
            Nation::firstOrCreate($nation);
        }

        return 'Nations built';
    }

    private function getLeagueData()
    {
        $totalPages = $this->getTotalPages();
        $data = [];

        for ($i = 1; $i <= $totalPages; $i++) {
            $res = $this->client->get("https://www.easports.com/uk/fifa/ultimate-team/api/fut/item?jsonParamObject=%7B%22page%22:{$i}%7D");
            $json = json_decode($res->getBody());

            echo "Got page {$i}/{$totalPages}\r\n";

            foreach ($json->items as $key => $item) {
                $league = $item->league;
                $leagueData = [
                    'name'      => $league->name,
                    'slug'      => $league->name,
                    'name_abbr' => $league->abbrName,
                    'ea_id'     => $league->id,
                    'img'       => $league->imgUrl,
                ];

                if (!in_array($leagueData, $data, true)) {
                    array_push($data, $leagueData);
                }
            }
        }

        return $data;
    }

    public function buildLeagues()
    {
        $leagues = $this->getLeagueData();

        foreach ($leagues as $league) {
            League::firstOrCreate($league);
        }

        return 'Leagues built';
    }

    private function getClubData()
    {
        $totalPages = $this->getTotalPages();
        $data = [];

        for ($i = 1; $i <= $totalPages; $i++) {
            $res = $this->client->get("https://www.easports.com/uk/fifa/ultimate-team/api/fut/item?jsonParamObject=%7B%22page%22:{$i}%7D");
            $json = json_decode($res->getBody());

            echo "Got page {$i}/{$totalPages}\r\n";

            foreach ($json->items as $key => $item) {
                $club = $item->club;
                $clubData = [
                    'name'             => $club->name,
                    'slug'             => $club->name,
                    'name_abbr'        => $club->abbrName,
                    'ea_id'            => $club->id,
                    'img'              => $club->imgUrl,
                    'img_dark_small'   => $club->imageUrls->dark->small,
                    'img_dark_medium'  => $club->imageUrls->dark->medium,
                    'img_dark_large'   => $club->imageUrls->dark->large,
                    'img_light_small'  => $club->imageUrls->normal->small,
                    'img_light_medium' => $club->imageUrls->normal->medium,
                    'img_light_large'  => $club->imageUrls->normal->large,
                ];

                if (!in_array($clubData, $data, true)) {
                    array_push($data, $clubData);
                }
            }
        }

        return $data;
    }

    public function buildClubs()
    {
        $clubs = $this->getClubData();

        foreach ($clubs as $club) {
            Club::firstOrCreate($club);
        }

        return 'Clubs built';
    }
}
