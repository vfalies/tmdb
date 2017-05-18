<?php

namespace Vfac\Tmdb;

/**
 * Tmdb wrapper core class
 */
class Tmdb
{

    // Private variables
    private $api_key         = null;                              // API Key
    private $language        = 'fr-FR';                           // Default language for API response
    private $base_api_url    = 'https://api.themoviedb.org/3/';   // Base URL of the API
    private $include_adult   = false;                             // Include adult content in search result
    private $page            = 1;                                 // API Page result
    // Protected variables
    protected $configuration = null; // API Configuration
    protected $genres        = null; // API Genres

    /**
     * Constructor
     * @param string $api_key TMDB API Key
     */

    public function __construct($api_key)
    {
        if ( ! extension_loaded('curl'))
        {
            throw new \Exception('cUrl extension is not loaded', 1003);
        }
        $this->api_key = $api_key;
    }

    /**
     * Send cUrl request to TMDB API
     * @param string $action API action to request
     * @param string|null $query Query of the request (optional)
     * @param array $options Array of options of the request (optional)
     * @return json string
     */
    public function sendRequest($action, $query = null, $options = array())
    {
        // Url construction
        $url = $this->base_api_url.$action;

        // Parameters
        $params            = [];
        $params['api_key'] = $this->api_key;
        if ( ! is_null($query))
        {
            $params['query'] = $query;
        }

        $params = array_merge($params, $options);

        // URL with paramters construction
        $url = $url.'?'.http_build_query($params);

        // Initialisation
        $ch = curl_init($url);
        if ($ch === false)
        {
            throw new \Exception('cUrl initialisation failed', 1002);
        }

        // cUrl options
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_ENCODING, "");
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        // cUrl execution
        $result = curl_exec($ch);
        if ($result === false)
        {
            throw new \Exception('cUrl failed : '.var_export(curl_getinfo($ch), true), 1004);
        }
        // cUrl HTTP Code response
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_code !== 200)
        {
            throw new \Exception('Incorrect HTTP Code ('.$http_code.') response : '.var_export(curl_getinfo($ch), true), 1005);
        }

        // cUrl closing
        curl_close($ch);

        $response = json_decode($result);
        if (is_null($response) || $response === false)
        {
            throw new \Exception('Movie search failed : '.var_export($result, true), 2001);
        }

        return $response;
    }

    /**
     * Get API Configuration
     * @return array
     */
    public function getConfiguration()
    {
        try
        {
            if (is_null($this->configuration))
            {
                $this->configuration = $this->sendRequest('configuration');
            }
            return $this->configuration;
        }
        catch (\Exception $ex)
        {
            throw new \Exception($ex->getMessage(), $ex->getCode(), $ex);
        }
    }

    /**
     * Check options rules before send request
     * @param array $options Array of options to validate
     * @return array
     * @throws \Exception
     */
    public function checkOptions(array $options)
    {
        $params                  = [];
        // Set default options
        $params['language']      = $this->language;
        $params['include_adult'] = $this->include_adult;
        $params['page']          = $this->page;
        // Check options
        foreach ($options as $key => $value)
        {
            switch ($key)
            {
                case 'year':
                    $params[$key] = $this->checkYear($value);
                    break;
                case 'language':
                    $params[$key] = $this->checkLanguage($value);
                    break;
                case 'include_adult':
                    $params[$key] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
                    break;
                case 'page':
                    $params[$key] = (int) $value;
                    break;
                default:
                    throw new \Exception('Unknown options');
            }
        }
        return $params;
    }

    /**
     * Check year format
     * @param mixed $year year to validate
     * @return int year validated
     * @throws \Exception
     */
    private function checkYear($year)
    {
        if ( ! is_numeric($year))
        {
            throw new \Exception('year param must be an integer');
        }
        $year = (int) $year;
        return $year;
    }

    /**
     * Check language
     * @param string $language Language string with format ISO 639-1
     * @return string Language string validated
     * @throws \Exception
     */
    private function checkLanguage($language)
    {
        $check = preg_match("#([a-z]{2})-([A-Z]{2})#", $language);
        if ($check === 0 || $check === false)
        {
            throw new \Exception("Incorrect language code : $language", 1001);
        }
        return $language;
    }

    /**
     * Magical getter
     * @param string $name
     * @return mixed
     * @throws \Exception
     */
    public function __get($name)
    {
        switch ($name)
        {
            case 'data':
                return $this->$name;
            default:
                throw new \Exception('Unknown property : '.$name);
        }
    }

}
