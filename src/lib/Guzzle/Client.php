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


namespace vfalies\tmdb\lib\Guzzle;

use vfalies\tmdb\Interfaces\HttpRequestInterface;
use GuzzleHttp\Exception\RequestException;
use vfalies\tmdb\Exceptions\NotFoundException;
use vfalies\tmdb\Exceptions\ServerErrorException;
use vfalies\tmdb\Exceptions\HttpErrorException;

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
     * Get response method
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
