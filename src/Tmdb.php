<?php

namespace vfalies\tmdb;

use vfalies\tmdb\Interfaces\TmdbInterface;
use vfalies\tmdb\Interfaces\HttpRequestInterface;
use Psr\Log\LoggerInterface;
use vfalies\tmdb\lib\Guzzle\Client as HttpClient;
use vfalies\tmdb\Exceptions\TmdbException;
use vfalies\tmdb\Exceptions\IncorrectParamException;
use vfalies\tmdb\Exceptions\ServerErrorException;

/**
 * Tmdb wrapper core class
 */
class Tmdb implements TmdbInterface
{

    // Private variables
    private $api_key         = null; // API Key
    private $language        = 'fr-FR'; // Default language for API response'; // Base URL of the API
    private $include_adult   = false; // Include adult content in search result
    private $page            = 1; // API Page result
    // Protected variables
    protected $configuration = null; // API Configuration
    protected $genres        = null; // API Genres
    // Public variables
    public $base_api_url     = 'https://api.themoviedb.org/3/'; // Base URL of the API

    /**
     *
     * @var LoggerInterface
     */
    public $logger           = null;

    /**
     * Constructor
     * @param string $api_key TMDB API Key
     * @param LoggerInterface $logger Logger used in the class
     */
    public function __construct($api_key, LoggerInterface $logger)
    {
        $this->api_key = $api_key;
        $this->logger  = $logger;
    }

    /**
     * Send request to TMDB API
     * @param HttpRequestInterface $http_request
     * @param string $action API action to request
     * @param string $query Query of the request (optional)
     * @param array $options Array of options of the request (optional)
     * @return \stdClass
     */
    public function sendRequest(HttpRequestInterface $http_request, $action, $query = null, array $options = array())
    {
        $this->logger->debug('Start sending HTTP request');
        $url = $this->buildHTTPUrl($action, $query, $options);
        $res = $http_request->getResponse($url);

        $response = json_decode($res->getBody());
        if (empty($response)) {
            $this->logger->error('Request Body can not be decode', array('action' => $action, 'query' => $query, 'options' => $options));
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
        if (!is_null($query)) {
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
    public function getConfiguration()
    {
        try {
            $this->logger->debug('Start getting configuration');
            if (is_null($this->configuration)) {
                $this->logger->debug('No configuration found, sending HTTP request to get it');
                $this->configuration = $this->sendRequest(new HttpClient(new \GuzzleHttp\Client()), 'configuration');
            }
            return $this->configuration;
        } catch (TmdbException $ex) {
            throw $ex;
        }
    }

    /**
     * Check options rules before send request
     * @param array $options Array of options to validate
     * @return array
     * @throws IncorrectParamException
     */
    public function checkOptions(array $options)
    {
        $params                  = [];
        // Set default options
        $params['language']      = $this->language;
        $params['include_adult'] = $this->include_adult;
        $params['page']          = $this->page;
        // Check options
        foreach ($options as $key => $value) {
            switch ($key) {
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
                    $this->logger->error('Unknown param options', array('options', $options));
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
    private function checkYear($year)
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
    private function checkLanguage($language)
    {
        $check = preg_match("#([a-z]{2})-([A-Z]{2})#", $language);
        if ($check === 0 || $check === false) {
            $this->logger->error('Incorrect language param option', array('language' => $language));
            throw new IncorrectParamException;
        }
        return $language;
    }
}
