<?php

namespace vfalies\tmdb;

use vfalies\tmdb\Interfaces\TmdbInterface;
use vfalies\tmdb\Interfaces\HttpRequestInterface;

/**
 * Tmdb wrapper core class
 */
class Tmdb implements TmdbInterface
{

    // Private variables
    private $api_key         = null; // API Key
    private $language        = 'fr-FR'; // Default language for API response
    public $base_api_url     = 'https://api.themoviedb.org/3/'; // Base URL of the API
    private $include_adult   = false; // Include adult content in search result
    private $page            = 1; // API Page result
    // Protected variables
    protected $configuration = null; // API Configuration
    protected $genres        = null; // API Genres

    /**
     * Constructor
     * @param string $api_key TMDB API Key
     */

    public function __construct(string $api_key)
    {
        $this->api_key = $api_key;
    }

    /**
     * Send cUrl request to TMDB API
     * @param Interfaces\HttpRequestInterface $http_request
     * @param string $action API action to request
     * @param string $query Query of the request (optional)
     * @param array $options Array of options of the request (optional)
     * @return \stdClass
     */
    public function sendRequest(HttpRequestInterface $http_request, string $action, string $query = null, array $options = array()): \stdClass
    {
        $url = $this->buildHTTPUrl($action, $query, $options);

        $http_request->setUrl($url);
        $http_request->setOption(CURLOPT_HEADER, 0);
        $http_request->setOption(CURLOPT_RETURNTRANSFER, true);
        $http_request->setOption(CURLOPT_MAXREDIRS, 10);
        $http_request->setOption(CURLOPT_ENCODING, "");
        $http_request->setOption(CURLOPT_TIMEOUT, 30);
        $http_request->setOption(CURLINFO_HEADER_OUT, true); // To gets header in curl_getinfo()

        $result = $http_request->execute();

        $http_code = $http_request->getInfo(CURLINFO_HTTP_CODE);

        if ($http_code !== 200)
        {
            if ($http_code == 429)
            {
                $message          = new \stdClass();
                $message->message = 'Request rate limit exceeded';
                $header_out       = $http_request->getInfo(CURLINFO_HEADER_OUT);
                $message->headers = var_export($header_out, true);

                throw new \Exception(json_encode($message), 1006);
            }
            throw new \Exception('Incorrect HTTP Code (' . $http_code . ') response : ' . var_export($http_request->getInfo(), true), 1005);
        }

        // cUrl closing
        $http_request->close();

        $response = json_decode($result);
        if (empty($response))
        {
            throw new \Exception('Search failed : ' . var_export($result, true), 2001);
        }
        return $response;
    }

    /**
     * Build URL for HTTP Call
     * @param string $action API action to request
     * @param string $query Query of the request (optional)
     * @param array $options Array of options of the request (optional)
     * @return string
     */
    private function buildHTTPUrl($action, $query, $options)
    {
        // Url construction
        $url = $this->base_api_url . $action;

        // Parameters
        $params            = [];
        $params['api_key'] = $this->api_key;
        if (!is_null($query))
        {
            $params['query'] = $query;
        }

        $params = array_merge($params, $options);

        // URL with paramters construction
        $url = $url . '?' . http_build_query($params);

        return $url;
    }

    /**
     * Get API Configuration
     * @return \stdClass
     */
    public function getConfiguration(): \stdClass
    {
        try
        {
            if (is_null($this->configuration))
            {
                $this->configuration = $this->sendRequest(new lib\CurlRequest(), 'configuration');
            }
            return $this->configuration;
        } catch (\Exception $ex)
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
    public function checkOptions(array $options): array
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
    private function checkYear(int $year): int
    {
        $year = (int) $year;
        return $year;
    }

    /**
     * Check language
     * @param string $language Language string with format ISO 639-1
     * @return string Language string validated
     * @throws \Exception
     */
    private function checkLanguage(string $language): string
    {
        $check = preg_match("#([a-z]{2})-([A-Z]{2})#", $language);
        if ($check === 0 || $check === false)
        {
            throw new \Exception("Incorrect language code : $language", 1001);
        }
        return $language;
    }

}
