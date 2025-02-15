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

    public static function get_gallery_urls(string $url, int $images_count){
        // make the request
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', $url);

        // if response is not OK, return null
        if ($response->getStatusCode() !== 200) {
            error_log('- Crawly: ERROR, CODE: '.$response->getStatusCode().' ON '.$url);
            return null;
        }

        // create a dom crawler instance
        $crawler = new Crawler($response->getContent());

        // position a crawler in #bodyContent
        $anchors = $crawler->filterXPath("//*[@id='bodyContent']");
        $anchors = $anchors->filter('a.mw-file-description');

        // get the images media page urls from each anchor
        $gallery_urls = [];
        for ($i = 0; $i < count($anchors); $i++) {

            if($i >= $images_count){ break; } // break the loop

            $anchor = $anchors->eq($i);
            $img = $anchor->filter('img');

            // add the thumbnail media page wikimedia link to original image
            $gallery_urls[] = [
                'thumbnail_url' => $img->attr('src'),
                'media_page_url' => 'https://commons.wikimedia.org'.$anchor->attr('href')
            ];
        }

        return $gallery_urls;
    }

    /*
     * Crawl wikimedia media page url and get media data, for example,
     * https://commons.wikimedia.org/wiki/File:USA_10096-7-8_HDR_Antelope_Canyon_Luca_Galuzzi_2007.jpg
     * and extract the image url
     */
    public static function get_media_data(string $file_url){
        // clean invisible characters
        $file_url = preg_replace('/^[\x00-\x1F\x7F]+/', '', $file_url);

        // remove spaces
        $file_url = trim($file_url);
        
        // make the request
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', $file_url);

        // if response is not OK, return null
        if ($response->getStatusCode() !== 200) {
            error_log('- Crawly: ERROR, CODE: '.$response->getStatusCode().' ON '.$file_url);
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
                // truncate the description
                $media_data[$locale] = ['description' => substr($loc_container->text(), 0, 255)];
            }
        }

        return $media_data;
    }
}
