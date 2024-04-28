<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

// DOM crawler helper class
class Crawly extends Model{

    /*
     * crawl wikimedia gallery, for example
     * https://commons.wikimedia.org/wiki/Antelope_Canyon
     * or
     * https://commons.wikimedia.org/wiki/Category:Antelope_Canyon
     * and fetch file page urls
     */

    public static function get_gallery_files_urls(string $url, int $images_count){
        // make the request
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', $url);

        // if response is not OK, return null
        if ($response->getStatusCode() !== 200) {
            error_log('ERROR, CODE: '.$response->getStatusCode().' ON '.$url);
            return null;
        }

        // create a dom crawler instance
        $crawler = new Crawler($response->getContent());

        // position a crawler in #bodyContent
        $anchors = $crawler->filterXPath("//*[@id='bodyContent']");
        $anchors = $anchors->filter('a.mw-file-description');

        // get the images file page urls
        $gallery_urls = [];
        for ($i = 0; $i < count($anchors); $i++) {

            if($i >= $images_count){ break; } // break the loop

            $anchor = $anchors->eq($i);

            // add the file page wikimedia link to original image
            $gallery_urls[] = 'https://commons.wikimedia.org'.$anchor->attr('href');

        }

        return $gallery_urls;
    }

    /*
     * crawl wikimedia file page url and get media data, for example,
     * https://commons.wikimedia.org/wiki/File:USA_10096-7-8_HDR_Antelope_Canyon_Luca_Galuzzi_2007.jpg
     * and extract the image url
     */
    public static function get_media_data(string $file_url){
        // make the request
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', $file_url);

        // if response is not OK, return null
        if ($response->getStatusCode() !== 200) {
            error_log('ERROR, CODE: '.$response->getStatusCode().' ON '.$file_url);
            return null;
        }

        // create a dom crawler instance
        $crawler = new Crawler($response->getContent());

        // position a crawler in the #file element
        $file = $crawler->filter('#file');

        $anchor = $file->filter('a')->first(); // get anchor inside
        error_log($anchor->attr('href'));

        $media_data = [
            'url' => $anchor->attr('href'),
        ];

        // add locale descriptions
        // position a crawler in the .fileinfotpl-type-information element
        $table = $crawler->filter('.fileinfotpl-type-information');

        foreach (config('translatable.locales') as $locale){
            $loc_container = $table->filter('.'.$locale)->first();

            if(count($loc_container) > 0){

                // remove span from $loc_container
                $span = $loc_container->filter('span')->first();
                if (count($span)) {
                    $span->getNode(0)->parentNode->removeChild($span->getNode(0));
                }

                $media_data[$locale] = ['description' => $loc_container->text()];
            }
        }

        return $media_data;
    }
}
