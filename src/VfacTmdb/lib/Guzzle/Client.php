<?php

declare(strict_types=1);
/**
 * This file is part of the Tmdb package.
 *
 * (c) Vincent Faliès <vincent@vfac.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017-2020
 */


namespace VfacTmdb\lib\Guzzle;

use VfacTmdb\Interfaces\HttpRequestInterface;
use GuzzleHttp\Exception\RequestException;
use VfacTmdb\Exceptions\NotFoundException;
use VfacTmdb\Exceptions\ServerErrorException;
use VfacTmdb\Exceptions\HttpErrorException;

/**
 * HTTP Client class for all HTTP request
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
class Client implements HttpRequestInterface
{

    /**
     * Client variable
     * @var \GuzzleHttp\ClientInterface
     */
    protected $guzzleClient;

    /**
     * Constructor
     * @param \GuzzleHttp\ClientInterface $guzzleClient
     */
    public function __construct(\GuzzleHttp\ClientInterface $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * Send response method from specific http method
     * @param  string $method  Http method (GET, POST, DELETE)
     * @param  string $url
     * @param  array  $options
     * @param array $form_params
     * @return mixed
     */
    private function sendResponse(string $method, string $url, array $options = [], array $form_params = array())
    {
        try {
            switch ($method) {
                case 'GET':
                    $params = array_merge($options, [
                        'headers' => ['Content-Type' => 'application/json;charset=utf-8']
                    ]);
                    break;
                default:
                    $params = array_merge($options, [
                        'headers' => ['Content-Type' => 'application/json;charset=utf-8'],
                        'body' => json_encode($form_params)
                    ]);
                    break;
            }

            return $this->guzzleClient->request($method, $url, $params);
        } catch (RequestException $e) {
            if (is_null($e->getResponse())) {
                throw new HttpErrorException;
            }
            switch ((int) $e->getResponse()->getStatusCode()) {
                case 404:
                    throw new NotFoundException($e->getMessage());
                default:
                    throw new ServerErrorException($e->getMessage());
            }
        }
    }

    /**
     * Get response method
     * @param string $url
     * @return mixed
     */
    public function getResponse(string $url)
    {
        return $this->sendResponse('GET', $url);
    }

    /**
     * Post response method
     * @param  string $url
     * @param  array  $options
     * @param  array $form_params
     * @return mixed
     */
    public function postResponse(string $url, array $options = [], array $form_params = array())
    {
        return $this->sendResponse('POST', $url, $options, $form_params);
    }

    /**
     * Delete response method
     * @param string $url
     * @return mixed
     */
    public function deleteResponse(string $url)
    {
        return $this->sendResponse('DELETE', $url);
    }
}
