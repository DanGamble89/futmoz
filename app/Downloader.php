<?php

namespace App;

use App\Models\Club;
use App\Models\League;
use App\Models\Nation;
use App\Models\Player;

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

    private function getPlayerData()
    {
        $totalPages = $this->getTotalPages();
        $data = [];

        for ($i = 1; $i <= $totalPages; $i++) {
            $res = $this->client->get("https://www.easports.com/uk/fifa/ultimate-team/api/fut/item?jsonParamObject=%7B%22page%22:{$i}%7D");
            $json = json_decode($res->getBody());

            echo "Got page {$i}/{$totalPages}\r\n";

            foreach ($json->items as $key => $item) {
                $player = $item;
                $playerData = [
                    'common_name'        => $player->commonName ? $player->commonName : "{$player->firstName} {$player->lastName}",
                    'first_name'         => $player->firstName,
                    'last_name'          => $player->lastName,
                    'card_name'          => $player->name,
                    'img'                => $player->headshotImgUrl,
                    'img_small'          => $player->headshot->smallImgUrl,
                    'img_medium'         => $player->headshot->medImgUrl,
                    'img_large'          => $player->headshot->largeImgUrl,
                    'img_totw_medium'    => $player->specialImages->medTOTWImgUrl,
                    'img_totw_large'     => $player->specialImages->largeTOTWImgUrl,
                    'slug'               => $player->name,
                    'ea_id'              => $player->baseId,
                    'ea_unique_id'       => intval($player->id),
                    'position'           => $player->position,
                    'position_full'      => $player->positionFull,
                    'play_style'         => $player->playStyle,
                    'play_style_id'      => $player->playStyleId,
                    'height'             => $player->height,
                    'weight'             => $player->weight,
                    'birthdate'          => $player->birthdate,
                    'overall_rating'     => $player->rating,
                    'acceleration'       => $player->acceleration,
                    'aggression'         => $player->aggression,
                    'agility'            => $player->agility,
                    'balance'            => $player->balance,
                    'ball_control'       => $player->ballcontrol,
                    'crossing'           => $player->crossing,
                    'curve'              => $player->curve,
                    'dribbling'          => $player->dribbling,
                    'finishing'          => $player->finishing,
                    'free_kick_accuracy' => $player->freekickaccuracy,
                    'gk_diving'          => $player->gkdiving,
                    'gk_handling'        => $player->gkhandling,
                    'gk_kicking'         => $player->gkkicking,
                    'gk_positioning'     => $player->gkpositioning,
                    'gk_reflexes'        => $player->gkreflexes,
                    'heading_accuracy'   => $player->headingaccuracy,
                    'interceptions'      => $player->interceptions,
                    'jumping'            => $player->jumping,
                    'long_passing'       => $player->longpassing,
                    'long_shots'         => $player->longshots,
                    'marking'            => $player->marking,
                    'penalties'          => $player->penalties,
                    'positioning'        => $player->positioning,
                    'potential'          => $player->potential,
                    'reactions'          => $player->reactions,
                    'short_passing'      => $player->shortpassing,
                    'shot_power'         => $player->shotpower,
                    'sliding_tackle'     => $player->slidingtackle,
                    'sprint_speed'       => $player->sprintspeed,
                    'standing_tackle'    => $player->standingtackle,
                    'stamina'            => $player->stamina,
                    'strength'           => $player->strength,
                    'vision'             => $player->vision,
                    'volleys'            => $player->volleys,
                    'foot'               => $player->foot,
                    'weak_foot'          => $player->weakFoot,
                    'skill_moves'        => $player->skillMoves,
                    'workrate_att'       => $player->atkWorkRate,
                    'workrate_def'       => $player->defWorkRate,
                    'player_type'        => $player->playerType,
                    'item_type'          => $player->itemType,
                    'card_att_1'         => $player->attributes[0]->value,
                    'card_att_2'         => $player->attributes[1]->value,
                    'card_att_3'         => $player->attributes[2]->value,
                    'card_att_4'         => $player->attributes[3]->value,
                    'card_att_5'         => $player->attributes[4]->value,
                    'card_att_6'         => $player->attributes[5]->value,
                    'quality'            => $player->quality,
                    'color'              => $player->color,
                    'is_gk'              => $player->isGK,
                    'is_special_type'    => $player->isSpecialType,
                    'traits'             => (string)implode(",", (array)$player->traits),
                    'specialities'       => (string)implode(",", (array)$player->specialities),
                ];

                if (!in_array($playerData, $data, true)) {
                    array_push($data, $playerData);
                }
            }
        }

        return $data;
    }

    public function buildPlayers()
    {
        $players = $this->getPlayerData();

        foreach ($players as $player) {
            Player::firstOrCreate($player);
        }

        return 'Players built';
    }
}
