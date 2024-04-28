<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

// DOM crawler helper class
class Crawly extends Model{

    // crawl wikimedia gallery and fetch images
    public static function crawl_gallery(string $url, int $images_count){
        // make the request
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', $url);

        // if response is not OK, return
        if ($response->getStatusCode() !== 200) {
            error_log('STATUS CODE: '.$response->getStatusCode());
            return null;
        }

        // create a dom crawler instance
        $crawler = new Crawler($response->getContent());

        // position a crawler in #bodyContent
        $anchors = $crawler->filterXPath("//*[@id='bodyContent']");
        $anchors = $anchors->filter('a.mw-file-description');

        // get the urls
        $image_urls = [];
        for ($i = 0; $i < count($anchors); $i++) {
            $node = $anchors->eq($i);

            $img = $node->filter('img')->first(); // get img inside node

            if ($img->count() > 0 && $i < $images_count) { //if img is found
                $image_urls[] = $img->attr('src');
            }
        }

        return $image_urls;
    }
}
