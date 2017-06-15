<?php

namespace vfalies\tmdb;

use vfalies\tmdb\Interfaces\TmdbInterface;
use vfalies\tmdb\Interfaces\HttpRequestInterface;
use Psr\Log\LoggerInterface;
use vfalies\tmdb\lib\Guzzle\Client as HttpClient;
use vfalies\tmdb\Exceptions\IncorrectParamException;
use vfalies\tmdb\Exceptions\ServerErrorException;

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
    protected $logger       = null;

    /**
     * Constructor
     * @param string $api_key TMDB API Key
     */
    public function __construct(string $api_key, LoggerInterface $logger = null)
    {
        $this->api_key = $api_key;
        $this->logger = null;
    }

    /**
     * Send cUrl request to TMDB API
     * @param HttpRequestInterface $http_request
     * @param string $action API action to request
     * @param string $query Query of the request (optional)
     * @param array $options Array of options of the request (optional)
     * @return \stdClass
     */
    public function sendRequest(HttpRequestInterface $http_request, string $action, string $query = null, array $options = array()): \stdClass
    {
        $url = $this->buildHTTPUrl($action, $query, $options);
        $res = $http_request->getResponse($url);

        $response = json_decode($res->getBody());
        if (empty($response))
        {
            throw new ServerErrorException();
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
     * @throws TmdbException
     */
    public function getConfiguration(): \stdClass
    {
        try
        {
            if (is_null($this->configuration))
            {
                $this->configuration = $this->sendRequest(new HttpClient(new \GuzzleHttp\Client()), 'configuration');
            }
            return $this->configuration;
        } catch (TmdbException $ex)
        {
            throw $ex;
        }
    }

    /**
     * Check options rules before send request
     * @param array $options Array of options to validate
     * @return array
     * @throws IncorrectParamException
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
                    throw new IncorrectParamException;
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
     * @throws IncorrectParamException
     */
    private function checkLanguage(string $language): string
    {
        $check = preg_match("#([a-z]{2})-([A-Z]{2})#", $language);
        if ($check === 0 || $check === false)
        {
            throw new IncorrectParamException;
        }
        return $language;
    }

}
