<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;




class Controller extends BaseController 

$xmlUrlSpain = "https://feeds.elpais.com/mrss-s/pages/ep/site/elpais.com/portada";
$xmlUrlGerman = "https://www.tagesschau.de/infoservices/alle-meldungen-100~rss2.xml";
&xmlUrlItalian = "https://www.ansa.it/sito/notizie/mondo/mondo_rss.xml"
$xmlUrlEnglish = "https://www.reutersagency.com/feed/?taxonomy=best-sectors&post_type=best"
{   
    $xmlUrl = "";

    function getNews($lang){

        switch ($lang) {
            case 'spain':
                $xmlUrl = $xmlUrlSpain;
                break;
            case 'german':
                $xmlUrl = $xmlUrlGerman;
                break;
            case 'italian':
                $xmlUrl = $xmlUrlItalian;
                break;
            case 'english':
                $xmlUrl = $xmlUrlEnglish;
                break;
            default:
                // 400 en caso de error
                header("HTTP/1.1 400 Bad Request");
                echo "Error: Invalid language";
                break;
        }

        
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $xmlUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);

        $response = curl_exec($ch);

        if ($response === false) {
            // 500 en caso error
            header("HTTP/1.1 500 Internal Server Error");
            echo "Error: " . curl_error($ch);
        } else {
            // type content
            header("Content-Type: application/xml");
        
            // output
            return $response;
        }
        
        // Close the cURL session
        curl_close($ch);

    }

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
?>