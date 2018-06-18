<?php
/**
 * API wrapper for Open Movie Database API (http://omdbapi.com/)
 * with responses for Slack slash commands
 *
 *  @version v1.2.0
 *  @license https://opensource.org/licenses/MIT
 *
 *  require 'IMDBBot.php';
 *  use MartijnOud\IMDBBot;
 *  $IMDBBot = new IMDBBot();
 *  echo json_encode($IMDBBot->q('Shawshank redemption'));
 *
 */

class IMDBBot
{

    // Optional OMDb (poster) API key
    private $apik = 'a782074';
    //private $apik = 'ffb9fc23';
    //private $apik = '51733191';
    //private $apik = '52422c61';

    /**
     * Uses the main OMDB API (?i= or ?t=)
     * Returns a single result with detailed info
     * @param  string $q Movie title or imdb ID
     * @return array with Slackable response
     */
    public function q($q)
    {

        // Make URL proof
        $q = urlencode($q);

        // Check if imdb ID or title
        // Call API
        if (preg_match("/tt\\d{7}/", $q)) {
            $item = $this->call('http://omdbapi.com/?i='.$q.'&apikey='.$this->apik);
        } else {
            $item = $this->call('http://omdbapi.com/?t='.$q.'&apikey='.$this->apik);
        }

        if ($item->Response != "True") {

            $payload = array(
                "response_type" => "in_channel",
                "text" => "Sorry I didn't find anything for _".urldecode($q)."_!",
            );

        } else {
        }


        return $item->imdbRating;

    }

    /**
     * Make a curl request to given $url and return json response
     * @param string $search
     * @return json_decoded contents of omdbapi
     */
    private function call($url)
    {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        return json_decode($response);
    }


}
