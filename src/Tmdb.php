<?php

/**
 * This file is part of the Tmdb package.
 *
 * (c) Vincent Faliès <vincent@vfac.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */

namespace vfalies\tmdb;

use vfalies\tmdb\Interfaces\TmdbInterface;
use vfalies\tmdb\Interfaces\HttpRequestInterface;
use Psr\Log\LoggerInterface;
use vfalies\tmdb\Exceptions\TmdbException;
use vfalies\tmdb\Exceptions\IncorrectParamException;
use vfalies\tmdb\Exceptions\ServerErrorException;

/**
 * Tmdb wrapper core class
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
class Tmdb implements TmdbInterface
{

    /**
     * API Key
     * @var string
     */
    private $api_key = null;

    /**
     * Default language for API response
     * @var string
     */
    private $language = 'fr-FR';

    /**
     * Include adult content in search result
     * @var bool
     */
    private $include_adult = false;

    /**
     * API Page result
     * @var int
     */
    private $page = 1;

    /**
     * API configuration
     * @var \stdClass
     */
    protected $configuration = null;

    /**
     * API Genres
     * @var \stdClass
     */
    protected $genres = null;

    /**
     * Base URL of the API
     * @var string
     */
    public $base_api_url = 'https://api.themoviedb.org/';

    /**
     * Logger
     * @var LoggerInterface
     */
    protected $logger = null;

    /**
     * API Version
     * @var int
     */
    protected $version = 3;

    /**
     * Http request object
     * @var HttpRequestInterface
     */
    protected $http_request = null;

    /**
     * Constructor
     * @param string $api_key TMDB API Key
     * @param int $version Version of API (Not yet used)
     * @param LoggerInterface $logger Logger used in the class
     * @param HttpRequestInterface $http_request
     */
    public function __construct(string $api_key, int $version = 3, LoggerInterface $logger, HttpRequestInterface $http_request)
    {
        $this->api_key      = $api_key;
        $this->logger       = $logger;
        $this->version      = $version;
        $this->http_request = $http_request;
    }

    /**
     * Send request to TMDB API with GET method
     * @param string $action API action to request
     * @param array $options Array of options of the request (optional)
     * @return \stdClass|null
     */
    public function getRequest(string $action, array $options = array()) : ?\stdClass
    {
        $this->logger->debug('Start sending HTTP request with GET method');
        return $this->sendRequest('GET', $action, $options);
    }

    /**
     * Send request to TMDB API with POST method
     * @param string $action API action to request
     * @param array $options Array of options of the request (optional)
     * @param array $form_params form_params for request options
     * @return \stdClass|null
     */
    public function postRequest(string $action, array $options = array(), array $form_params = array()) : ?\stdClass
    {
        $this->logger->debug('Start sending HTTP request with POST method');
        return $this->sendRequest('POST', $action, $options, $form_params);
    }

    /**
     * Send request to TMDB API with GET method
     * @param string $method HTTP method (GET, POST)
     * @param string $action API action to request
     * @param array $options Array of options of the request (optional)
     * @param array $form_params form params request options
     * @return \stdClass|null
     */
    protected function sendRequest(string $method, string $action, array $options = array(), array $form_params = array()) : ?\stdClass
    {
        $url = $this->buildHTTPUrl($action, $options);

        switch ($method) {
              case 'GET':
                  $res = $this->http_request->getResponse($url);
                  break;
              case 'POST':
                  $res = $this->http_request->postResponse($url, $options, $form_params);
                  break;
            default:
                throw new IncorrectParamException("$method is a unknown method");
                break;
        }

        $response = json_decode($res->getBody());
        if (empty($response)) {
            $this->logger->error('Request Body can not be decode', array('action' => $action, 'options' => $options));
            throw new ServerErrorException();
        }
        return $response;
    }

    /**
     * Build URL for HTTP Call
     * @param string $action API action to request
     * @param array $options Array of options of the request (optional)
     * @return string
     */
    private function buildHTTPUrl(string $action, array $options) : string
    {
        // Url construction
        $url = $this->base_api_url . $this->version . '/' . $action;

        // Parameters
        $params            = [];
        $params['api_key'] = $this->api_key;

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
    public function getConfiguration() : \stdClass
    {
        try {
            $this->logger->debug('Start getting configuration');
            if (is_null($this->configuration)) {
                $this->logger->debug('No configuration found, sending HTTP request to get it');
                $this->configuration = $this->getRequest('configuration');
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
    public function checkOptions(array $options) : array
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
                case 'sort_by':
                    $params[$key] = $this->checkSort($value);
                    break;
                case 'query':
                    $params[$key] = trim($value);
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
     */
    private function checkYear($year) : int
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
    private function checkLanguage(string $language) : string
    {
        $check = preg_match("#([a-z]{2})-([A-Z]{2})#", $language);
        if ($check === 0 || $check === false) {
            $this->logger->error('Incorrect language param option', array('language' => $language));
            throw new IncorrectParamException;
        }
        return $language;
    }

    /**
     * Check sort direction
     * @param  string $direction direction of sorting
     * @return string            Sort string validated
     * @throws IncorrectParamException
     */
    private function checkSort(string $direction) : string
    {
        switch ($direction) {
            case 'asc':
            case 'desc':
                break;
            default:
                throw new IncorrectParamException;
        }
        return 'created_at.'.$direction;
    }

    /**
     * Get logger
     * @return LoggerInterface
     */
    public function getLogger() : LoggerInterface
    {
        return $this->logger;
    }
}
