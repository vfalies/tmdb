<?php

namespace vfalies\tmdb\lib\Guzzle;

use vfalies\tmdb\Interfaces\HttpRequestInterface;
use GuzzleHttp\Exception\RequestException;
use vfalies\tmdb\Exceptions\NotFoundException;
use vfalies\tmdb\Exceptions\ServerErrorException;
use vfalies\tmdb\Exceptions\HttpErrorException;

class Client implements HttpRequestInterface
{

    /**
     * @var \GuzzleHttp\ClientInterface
     */
    protected $guzzleClient;

    /**
     * @param \GuzzleHttp\ClientInterface $guzzleClient
     */
    public function __construct(\GuzzleHttp\ClientInterface $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * @param  string                               $url
     */
    public function getResponse($url)
    {
        try
        {
            return $this->guzzleClient->request('GET', $url);
        }
        catch (RequestException $e)
        {
            if (is_null($e->getResponse()))
            {
                throw new HttpErrorException;
            }
            switch ((int) $e->getResponse()->getStatusCode())
            {
                case 404:
                    throw new NotFoundException($e->getMessage());
                default:
                    throw new ServerErrorException($e->getMessage());
            }
        }
    }

}
