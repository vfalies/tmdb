<?php

namespace vfalies\tmdb\lib\Guzzle;

use vfalies\tmdb\Interfaces\HttpRequestInterface;
use GuzzleHttp\Exception\BadResponseException;
use vfalies\tmdb\Exceptions\NotFoundException;
use vfalies\tmdb\Exceptions\ServerErrorException;

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
     * @throws \FeedIo\Adapter\NotFoundException
     * @throws \FeedIo\Adapter\ServerErrorException
     * @return \FeedIo\Adapter\ResponseInterface
     */
    public function getResponse($url)
    {
        try
        {
            return new Response($this->guzzleClient->request('get', $url));
        }
        catch (BadResponseException $e)
        {
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
