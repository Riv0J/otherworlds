<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\CssSelector\CssSelectorConverter;
use Symfony\Component\HttpClient\HttpClient;

class OHelper extends Model
{
    use HasFactory;

    public static function makeUrlFriendly(string $filename){
        // Reemplazar caracteres especiales con guiones medios
        $filename = preg_replace('/[\/?%*:|"<>\\.]/', '-', $filename);

        // Reemplazar espacios en blanco con guiones bajos
        $filename = str_replace(' ', '_', $filename);

        // Reemplazar comillas simples con un string vacío
        $filename = str_replace("'", '', $filename);

        // Convertir todo a minúsculas
        $filename = strtolower($filename);

        return $filename;
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
            for ($i=1; $i < 4; $i++) {
                if($i > 2){
                    $html_content = $html_content.' ';
                }
                $container_element = $crawler->filterXPath("//*[@id='bodyContent']//p[".$i."]");
                $html_content = $html_content.'<p>'.OHelper::cleanse_crawler_html($container_element).'</p>';

                if($i != 3){
                    $html_content = $html_content.'<br>';
                }
            }

            return [
                'title' => $title_container->text(),
                'content' => $html_content,
            ];

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
}
