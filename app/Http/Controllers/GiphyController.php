<?php

namespace App\Http\Controllers;

use App\Http\Resources\GamesResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GiphyController extends Controller
{

    public $api_instance;
    public $api_key;

    public function __construct() {
        $this->api_instance = new \GPH\Api\DefaultApi();
        $this->api_key = env('GIPHY_KEY');
    }

    /**
     * Return Gifs in response to search results
     *
     * @param Request $request
     * @return \GPH\Model\InlineResponse200
     */
    public function getGifs(Request $request)
    {
        $query = $request->get('gif_text'); // string | Search query term or phrase.
        $limit = 6; // int | The maximum number of records to return.
        $offset = 0; // int | An optional results offset. Defaults to 0.
        $rating = "g"; // string | Filters results by specified rating.
        $lang = "en"; // string | Specify default country for regional content; use a 2-letter ISO 639-1 country code. See list of supported languages <a href = \"../language-support\">here</a>.
        $fmt = "json"; // string | Used to indicate the expected response format. Default is Json.

        try {
            $result = $this->api_instance->gifsSearchGet($this->api_key, $query, $limit, $offset, $rating, $lang, $fmt);
            return $result['data'];
        } catch (\Exception $e) {
            echo 'Exception when calling DefaultApi->gifsSearchGet: ', $e->getMessage(), PHP_EOL;
        }
    }
}
