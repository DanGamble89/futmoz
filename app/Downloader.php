<?php

namespace App;

use App\Models\Nation;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Promise;
use Psr\Http\Message\ResponseInterface;

class Downloader
{
    public $url = 'https://www.easports.com/uk/fifa/ultimate-team/api/fut/item?jsonParamObject=%7B%22page%22:1%7D';

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getTotalPages()
    {
        try {
            $res = $this->client->request('GET', $this->url);
        } catch (ClientException $e) {
            var_dump($e->getResponse());
        }
        $json = json_decode($res->getBody());

        return $json->totalPages;
    }

    public function getData()
    {
        $totalPages = $this->getTotalPages();
        $nationData = [];

        for($i = 1; $i <= $totalPages; $i++) {
            $res = $this->client->get("https://www.easports.com/uk/fifa/ultimate-team/api/fut/item?jsonParamObject=%7B%22page%22:{$i}%7D");
            $json = json_decode($res->getBody());

            foreach ($json->items as $item) {
                $nationJson = $item->nation;

                array_push($nationData, [
                    'name'       => $nationJson->name,
                    'slug'       => $nationJson->name,
                    'name_abbr'  => $nationJson->abbrName,
                    'ea_id'      => $nationJson->id,
                    'img'        => $nationJson->imgUrl,
                    'img_small'  => $nationJson->imageUrls->small,
                    'img_medium' => $nationJson->imageUrls->medium,
                    'img_large'  => $nationJson->imageUrls->large,
                ]);
            }
        }

        foreach ($nationData as $nation) {
            Nation::firstOrCreate($nation);
        }

//        for($i = 1; $i <= $totalPages; $i++) {
//            $res = $this->client->request('GET', "https://www.easports.com/uk/fifa/ultimate-team/api/fut/item?jsonParamObject=%7B%22page%22:{$i}%7D");
//
//            $json = json_decode($res->getBody());
//
//            foreach($json->items as $item) {
//                echo $item->name;
//            }
//        }

//        $results = Promise\unwrap($nationData);

//        return $results;
    }
}
