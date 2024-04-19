<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\CssSelector\CssSelectorConverter;
use Symfony\Component\HttpClient\HttpClient;

class OHelper extends Model{
    use HasFactory;

    public static function makeUrlFriendly(string $filename) {
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

    public static function getPageContent(string $url)
{
    // Crear una instancia del cliente HTTP
    $httpClient = HttpClient::create();

    // Realizar la solicitud GET a la URL especificada
    $response = $httpClient->request('GET', $url);

    // Verificar si la solicitud fue exitosa (código de estado 200)
    if ($response->getStatusCode() === 200) {
        // Obtener el contenido de la respuesta
        $content = $response->getContent();

        // Crear una instancia de Crawler para analizar el contenido HTML
        $crawler = new Crawler($content);

        // Obtener el contenido del elemento con el selector dado
        $p_num = 1;
        $tries = 5;

        $container_element = $crawler->filterXPath("//*[@id='bodyContent']//p[".$p_num."]");
        $text = $container_element->html();
        while ($tries > 0 && strlen($text) < 20){
            $container_element = $crawler->filterXPath("//*[@id='bodyContent']//p[".$p_num."]");
            $text = $container_element->html();
            $tries--;
            $p_num++;
        }

        //delete sup elements
        $container_element->filter('sup')->each(function ($supNode) {
            $supNode->getNode(0)->parentNode->removeChild($supNode->getNode(0));
        });

        return $container_element->html();
    } else {
        // Si la solicitud no fue exitosa, retornar null o algún mensaje de error
        return null;
    }
}
}
