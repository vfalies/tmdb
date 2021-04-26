<?php declare(strict_types=1);

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

namespace VfacTmdb;

use VfacTmdb\Interfaces\TmdbInterface;
use VfacTmdb\Interfaces\HttpRequestInterface;
use Psr\Log\LoggerInterface;
use VfacTmdb\Exceptions\TmdbException;
use VfacTmdb\Exceptions\IncorrectParamException;
use VfacTmdb\Exceptions\ServerErrorException;

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
     * Request object
     * @var \stdClass
     */
    protected $request;
    /**
     * Last request url
     * @var string
     */
    protected $url = null;

    /**
     * Constructor
     * @param string $api_key TMDB API Key
     * @param int $version Version of API (Not yet used)
     * @param LoggerInterface $logger Logger used in the class
     * @param HttpRequestInterface $http_request
     */
    public function __construct(string $api_key, int $version, LoggerInterface $logger, HttpRequestInterface $http_request)
    {
        $this->api_key      = $api_key;
        $this->logger       = $logger;
        $this->version      = $version;
        $this->http_request = $http_request;
        $this->request      = new \stdClass;
    }

    /**
     * Send request to TMDB API with GET method
     * @param string $action API action to request
     * @param array $options Array of options of the request (optional)
     * @return \stdClass|null
     */
    public function getRequest(string $action, array $options = array()) : ?\stdClass
    {
        $this->logger->debug('Start sending HTTP request with GET method', array('action' => $action, 'options' => $options));
        $this->url = $this->buildHTTPUrl($action, $options);
        return $this->sendRequest('GET', $this->url);
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
        $this->logger->debug('Start sending HTTP request with POST method', array('action' => $action, 'options' => $options, 'form_params' => $form_params));
        $this->url = $this->buildHTTPUrl($action, $options);
        return $this->sendRequest('POST', $this->url, $form_params);
    }

    /**
     * Send request to TMDB API with DELETE method
     * @param  string $action  API action to request
     * @param  array  $options Array of options of the request (optional)
     * @return \stdClass|null
     */
    public function deleteRequest(string $action, array $options = array()) : ?\stdClass
    {
        $this->logger->debug('Start sending HTTP request with DELETE method', array('action' => $action, 'options' => $options));
        $this->url = $this->buildHTTPUrl($action, $options);
        return $this->sendRequest('DELETE', $this->url);
    }

    /**
     * Send request to TMDB API with GET method
     * @param string $method HTTP method (GET, POST)
     * @param string $url API url to request
     * @param array $form_params form params request options
     * @return \stdClass|null
     */
    protected function sendRequest(string $method, string $url, array $form_params = array()) : ?\stdClass
    {
        try {
            $method_name = strtolower($method) . 'Response';
            $res = $this->http_request->$method_name($url, [], $form_params);
            $response = $this->decodeRequest($res, $method, $url, $form_params);
            return $response;
        } catch (TmdbException $e) {
            $this->logger->error('sendRequest failed : ' . $e->getMessage(), array('method' => $method, 'url' => $url, 'form_params' => $form_params));
            throw $e;
        }
    }

    /**
     * Decode request response
     * @param  mixed $res
     * @param  string $method
     * @param  string $url
     * @param  array $form_params
     * @return \stdClass
     */
    private function decodeRequest($res, $method, $url, $form_params) : \stdClass
    {
        $content = $res->getBody();

        if (is_object($content)) {
            $content = $content->getContents();
        }
        if (empty($content)) {
            $this->logger->error('Request Body empty', array('method' => $method, 'url' => $url, 'form_params' => $form_params));
            throw new ServerErrorException();
        }
        $response = json_decode($content);
        if (empty($response)) {
            $this->logger->error('Request Body can not be decode', array('method' => $method, 'url' => $url, 'form_params' => $form_params));
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
     * Get logger
     * @return LoggerInterface
     */
    public function getLogger() : LoggerInterface
    {
        return $this->logger;
    }

    /**
     * Magical property getter
     * @param  string $name Name of the property
     * @return string       Value of the property
     */
    public function __get(string $name) : string
    {
        switch ($name) {
            case 'url':
                return $this->$name;
            default:
                throw new IncorrectParamException;
        }
    }

    /**
     * @inheritDoc
     */
    public function checkOptionYear(array $options, array &$return) : void
    {
        if (isset($options['year'])) {
            $return['year'] = (int) $options['year'];
        }
    }

    /**
     * @inheritDoc
     */
    public function checkOptionLanguage(array $options, array &$return) : void
    {
        if (isset($options['language'])) {
            $check = preg_match("#([a-z]{2})-([A-Z]{2})#", $options['language']);
            if ($check === 0 || $check === false) {
                $this->logger->error('Incorrect language param option', array('language' => $options['language']));
                throw new IncorrectParamException;
            }
            $return['language'] = $options['language'];
        }
    }

    /**
     * @inheritDoc
     */
    public function checkOptionIncludeAdult(array $options, array &$return) : void
    {
        if (isset($options['include_adult'])) {
            $return['include_adult'] = filter_var($options['include_adult'], FILTER_VALIDATE_BOOLEAN);
        }
    }

    /**
     * @inheritDoc
     */
    public function checkOptionPage(array $options, array &$return) : void
    {
        if (isset($options['page'])) {
            $return['page'] = (int) $options['page'];
        }
    }

    /**
     * @inheritDoc
     */
    public function checkOptionSortBy(array $options, array &$return) : void
    {
        if (isset($options['sort_by'])) {
            switch ($options['sort_by']) {
                case 'asc':
                case 'desc':
                    break;
                default:
                    throw new IncorrectParamException;
            }
            $return['sort_by'] = 'created_at.' . $options['sort_by'];
        }
    }

    /**
     * @inheritDoc
     */
    public function checkOptionQuery(array $options, array &$return) : void
    {
        if (isset($options['query'])) {
            $return['query'] = trim($options['query']);
        }
    }

    /**
     * @inheritDoc
     */
    public function checkOptionSessionId(array $options, array &$return) : void
    {
        if (isset($options['session_id'])) {
            $return['session_id'] = trim($options['session_id']);
        }
    }

    /**
     * @inheritDoc
     */
    public function checkOptionExternalSource(array $options, array &$return) : void
    {
        if (isset($options['external_source'])) {
            switch ($options['external_source']) {
                case 'imdb_id':
                case 'freebase_mid':
                case 'freebase_id':
                case 'tvdb_id':
                case 'tvrage_id':
                case 'facebook_id':
                case 'twitter_id':
                case 'instagram_id':
                    $return['external_source'] = trim($options['external_source']);
                    break;
                default:
                    throw new IncorrectParamException;
            }
        }
    }

    /*
     * Check date option
     * @param  string $option
     * @param  string $format
     * @return bool
     * @author Steve Richter <steve@nerdbra.in>
     */
    public function checkOptionDate(string $option, string $format = 'Y-m-d') : bool
    {
        $date = \DateTime::createFromFormat($format, $option);

        return $date && $date->format($format) === $option;
    }

    /**
     * Check date range options
     * @param  array $options
     * @param  array &$return Return array to save valid options
     * @return void
     * @throws IncorrectParamException
     * @author Steve Richter <steve@nerdbra.in>
     */
    public function checkOptionDateRange(array $options, array &$return) : void
    {
        foreach (['start_date', 'end_date'] as $optionName) {
            if (isset($options[$optionName])) {
                if ($this->checkOptionDate($options[$optionName])) {
                    $return[$optionName] = $options[$optionName];
                    continue;
                }

                $this->logger->error('Incorrect date param option', array($optionName => $options[$optionName]));
                throw new IncorrectParamException;
            }
        }
    }
}
