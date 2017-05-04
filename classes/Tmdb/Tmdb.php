<?php

namespace Vfac\Tmdb;

/**
 * Tmdb wrapper core class
 */
abstract class Tmdb
{
    // Private variables
    private $api_key       = null;                              // API Key
    private $language      = 'fr-FR';                           // Default language for API response
    private $base_api_url  = 'https://api.themoviedb.org/3/';   // Base URL of the API
    private $include_adult = false;                             // Include adult content in search result

    // Protected variables
    protected $response    = null; // Raw response of the API
    protected $infos       = null; // Informations from API response
    protected $query       = [];   // Query parameters ask to the API

    /**
     * Constructor
     * @param string $api_key TMDB API Key
     */
    public function __construct($api_key)
    {
        if ( ! extension_loaded('curl'))
        {
            throw new Exception('cUrl extension is mandatory', 1003);
        }
        $this->api_key = $api_key;
    }

    /**
     * Send cUrl request to TMDB API
     * @param string $action
     * @param string $query
     * @param int|null $year
     * @return json string
     */
    protected function sendRequest($action, $query, $year = null)
    {
        // Url construction
        $url = $this->base_api_url.$action;

        // Parameters
        $params                  = [];
        $params['api_key']       = $this->api_key;
        $params['language']      = $this->language;
        $params['page']          = 1;
        $params['include_adult'] = $this->include_adult;
        $params['query']         = $query;

        if ( ! is_null($year))
        {
            if ( ! is_numeric($year))
            {
                throw new Exception('Year must be an integer', 1005);
            }
            $params['year'] = (int) $year;
        }

        // URL with paramters construction
        $url = $url.'?'.http_build_query($params);

        // Initialisation
        $ch = curl_init($url);
        if ($ch === false)
        {
            throw new Exception('cUrl initialisation failed', 1002);
        }

        // cUrl options
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 4);

        // cUrl execution
        $result = curl_exec($ch);
        if ($result === false)
        {
            throw new Exception('cUrl failed : '.var_export(curl_getinfo($ch), true), 1004);
        }

        // cUrl closing
        curl_close($ch);

        return $result;
    }

    /**
     * Set default language code for API response
     * @param string $language
     * @throws Exception
     */
    protected function setLanguage($language)
    {
        $check = preg_match('([a-z]{2})-([A-Z]{2})', $language);
        if ($check === 0 || $check === false)
        {
            throw new Exception("Incorrect language code : $language", 1001);
        }

        $this->language = $language;
    }

}
