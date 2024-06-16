<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

class OHelper extends Model{
    public static function sluggify(string $string){
        // replace weird characters with underscore
        $string = preg_replace('/[\/?%*:|"<>\\.]/', '_', $string);

        // replace spaces with hyphen
        $string = str_replace(' ', '-', $string);

        // replace single quotes with empty
        $string = str_replace("'", '', $string);

        // replace accents and special characters
        $string = str_replace('ñ', 'n', $string);
        $string = preg_replace('/[áä]/u', 'a', $string);
        $string = preg_replace('/[éë]/u', 'e', $string);
        $string = preg_replace('/[íï]/u', 'i', $string);
        $string = preg_replace('/[óö]/u', 'o', $string);
        $string = preg_replace('/[úü]/u', 'u', $string);

        // lowercase
        return strtolower($string);
    }

    //given a WIKIPEDIA URL, crawl the DOM and extract the html content
    public static function getWikiContent(string $url){
        // make the request
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', $url);

        // verify if the response code is OK
        if ($response->getStatusCode() === 200) {
            // create a dom crawler instance
            $crawler = new Crawler($response->getContent());

            // get the first 'p' element of the page, and the #firstHeading
            $title_container = $crawler->filterXPath("//*[@id='firstHeading']");

            $html_content = '';

            $extra_tries = 2;
            $paragraph_to_scrape = 3;
            for ($i=1; $i < $paragraph_to_scrape+1; $i++) {
                $container_element = $crawler->filterXPath("//*[@id='bodyContent']//p[".$i."]");

                if ($container_element->count() == 0) { break; }
                $text = OHelper::cleanse_crawler_html($container_element);

                if(strlen($text)>10){
                    $html_content = $html_content.'<p>'.$text.'</p>';
                } else {
                    if($extra_tries > 0){
                        $extra_tries--;
                        $paragraph_to_scrape++;
                    }
                }
            }

            // try to extract latitud n longitude from the page, if not successfull they will be null
            $latitude_container = $crawler->filterXPath("//*[@id='bodyContent']//*[contains(concat(' ', normalize-space(@class), ' '), ' infobox ')][1]//*[contains(concat(' ', normalize-space(@class), ' '), ' latitude ')][1]");
            $longitude_container = $crawler->filterXPath("//*[@id='bodyContent']//*[contains(concat(' ', normalize-space(@class), ' '), ' infobox ')][1]//*[contains(concat(' ', normalize-space(@class), ' '), ' longitude ')][1]");

            $variables = [
                'title' => $title_container->text(),
                'content' => $html_content,
                'gallery_url' => null,
                'latitude' => null,
                'longitude' => null,
            ];

            if ($latitude_container->count() > 0 && $longitude_container->count() > 0) {
                $latitude_dms = $latitude_container->text();
                $longitude_dms = $longitude_container->text();

                $latitude_parts = OHelper::getDMS($latitude_dms);
                $longitude_parts = OHelper::getDMS($longitude_dms);

                $variables['latitude'] = OHelper::DMSToDecimal($latitude_parts['degrees'], $latitude_parts['minutes'], $latitude_parts['seconds'], $latitude_parts['direction']);
                $variables['longitude'] = OHelper::DMSToDecimal($longitude_parts['degrees'], $longitude_parts['minutes'], $longitude_parts['seconds'], $longitude_parts['direction']);
            }

            //try to get gallery_url
            $gallery_link = $crawler->filter('a')->reduce(function (Crawler $node) {
                return strpos($node->attr('href'), 'https://commons.wikimedia.org/wiki/Category:') !== false;
            })->first();

            //assign gallery_url
            if ($gallery_link->count() > 0) {
                $variables['gallery_url'] = $gallery_link->attr('href');
            } else {
                //try again with source title
                $gallery_link = $crawler->filter('a')->reduce(function (Crawler $node) use ($variables) {
                    return strpos($node->attr('href'), 'https://commons.wikimedia.org/wiki/' . $variables['title']) !== false;
                })->first();
            }
            return $variables;

        } else {
            return null;
        }
    }

    public static function cleanse_crawler_html(Crawler $crawler){
        // delete banned nodes
        $banned_tags = ['sup', 'link', 'style'];
        foreach ($banned_tags as $tag) {
            $crawler->filter($tag)->each(function ($node) {
                $node->getNode(0)->parentNode->removeChild($node->getNode(0));
            });
        }

        // delete nodes that contain banned classes in their className
        $banned_classes = ['IPA', 'IPA-label', 'rt-commentedText'];
        foreach ($banned_classes as $class) {
            $crawler->filterXPath('//*[contains(concat(" ", normalize-space(@class), " "), " ' . $class . ' ")]')->each(function ($node) {
                $node->getNode(0)->parentNode->removeChild($node->getNode(0));
            });
        }

        // edit links, just leave the link's text
        $dissolve_nodes = ['a', 'i'];
        foreach ($dissolve_nodes as $tag) {
            $crawler->filter($tag)->each(function ($node) {
                //replace node with just the text
                $node->getNode(0)->parentNode->replaceChild(new \DOMText($node->text()), $node->getNode(0));
            });
        }

        // delete out strings from the content_html
        $content_html = $crawler->html();
        $banned_strings = ['()', '( )', ' , '];
        foreach ($banned_strings as $str) {
            $content_html = str_replace($str, '', $content_html);
        }

        //delete ";" after "("
        $content_html = preg_replace('/;(?=\()/', '', $content_html);
        return trim($content_html);
    }

    public static function DMSToDecimal($degrees, $minutes, $seconds, $direction): float {
        $degrees = (float)$degrees;
        $minutes = (float)$minutes;
        $seconds = (float)$seconds;

        $decimal = $degrees + ($minutes / 60) + ($seconds / 3600);

        // when "S" or "W" its negative
        if ($direction === 'S' || $direction === 'W') {
            $decimal *= -1;
        }

        return number_format($decimal, 6, '.', '');
    }

    public static function getDMS(string $dms){
        $dms = trim($dms);

        $variables= [
            'degrees' => 0,
            'minutes' => 0,
            'seconds' => 0,
            'direction' => null
        ];

        // explode to get degrees
        $dms = str_replace('°','-',$dms); // replace to -
        $dms = str_replace('′',"'",$dms); // replace to '
        $dms = str_replace('″','"',$dms); // replace to "

        $parts = explode("-", $dms);

        //if there is more than one part, explode was successfull
        if(count($parts) > 1) {
            $variables['degrees'] = trim($parts[0]); //degrees is the left side of string
            $dms = $parts[1]; //the right side of string reassinged to dms
        }

        // explode to get minutes
        $parts = explode("'", $dms);

        //if there is more than one part, explode was successfull
        if(count($parts) > 1) {
            $variables['minutes'] = trim($parts[0]); //minutes is the left side of string
            $dms = $parts[1]; //the right side of string reassinged to dms
        }

        // explode to get seconds
        $parts = explode('"', $dms);

        //if there is more than one part, explode was successfull
        if(count($parts) > 1) {
            $variables['seconds'] = trim($parts[0]); //seconds is the left side of string
            $dms = $parts[1]; //the right side of string reassinged to dms
        }

        $ultima_letra = $dms[-1]; // Obtiene el último carácter de la cadena
        if (preg_match('/[a-zA-Z]/', $ultima_letra)) {
            $variables['direction'] = $ultima_letra;
        }
        return $variables;
    }

    /**
     * Download an image to the server, returns an UploadedFile
     * @param string $url
     * @return array|null
     */
    public static function download_image($url) {
        $client = HttpClient::create();
        $response = $client->request('GET', $url);

        if ($response->getStatusCode() !== 200) {
            error_log('url '.$url);
            error_log('CODE '.$response->getStatusCode());
            return null;
        }

        $imageContent = $response->getContent();

        // Obtén la información de la URL
        $urlInfo = parse_url($url);
        $pathInfo = pathinfo($urlInfo['path']);
        $extension = $pathInfo['extension'] ?? '';

        // Crea un archivo temporal con la extensión correcta
        $tempFilePath = tempnam(sys_get_temp_dir(), 'img') . '.' . $extension;
        file_put_contents($tempFilePath, $imageContent);

        return [
            'temp_path' => $tempFilePath,
            'extension' => $extension
        ];
    }

}
