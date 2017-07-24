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

use vfalies\tmdb\Exceptions\NotFoundException;
use vfalies\tmdb\Exceptions\IncorrectParamException;
use vfalies\tmdb\Interfaces\TmdbInterface;

/**
 * Media class
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
class Media
{
    /**
     * Tmdb object
     * @var TmdbInterface
     */
    protected $tmdb = null;
    /**
     * Configuration
     * @var \stdClass
     */
    protected $conf = null;
    /**
     * Logger
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger = null;

    /**
     * Constructor
     * @param \vfalies\tmdb\Interfaces\TmdbInterface $tmdb
     */
    public function __construct(TmdbInterface $tmdb)
    {
        $this->tmdb   = $tmdb;
        $this->logger = $tmdb->getLogger();
        $this->conf   = $this->tmdb->getConfiguration();
    }

    /**
     * Get backdrop url
     * @param string $path
     * @param string $size
     * @return string|null
     */
    public function getBackdropUrl($path, $size = 'w780')
    {
        return $this->getImage('backdrop', $size, $path);
    }

    /**
     * Get poster url
     * @param string $path
     * @param string $size
     * @return string
     */
    public function getPosterUrl($path, $size = 'w185')
    {
        return $this->getImage('poster', $size, $path);
    }

    /**
     * Get logos url
     * @param string $path
     * @param string $size
     * @return string
     */
    public function getlogoUrl($path, $size = 'w92')
    {
        return $this->getImage('logo', $size, $path);
    }

    /**
     * Get profile url
     * @param string $path
     * @param string $size
     * @return string
     */
    public function getProfileUrl($path, $size = 'w185')
    {
        return $this->getImage('profile', $size, $path);
    }

    /**
     * Get poster url
     * @param string $path
     * @param string $size
     * @return string
     */
    public function getStillUrl($path, $size = 'w185')
    {
        return $this->getImage('still', $size, $path);
    }

    /**
     * Get image url from type and size
     * @param string $type
     * @param string $size
     * @param string $filepath
     * @return string
     * @throws NotFoundException
     * @throws IncorrectParamException
     */
    private function getImage($type, $size, $filepath)
    {
        if (!isset($this->conf->images->base_url))
        {
            $this->logger->error('No image base url found from configuration');
            throw new NotFoundException;
        }
        $sizes = $type . '_sizes';
        if (!in_array($size, $this->conf->images->$sizes))
        {
            $this->logger->error('Incorrect param image size', array('type' => $type, 'size' => $size, 'filepath' => $filepath));
            throw new IncorrectParamException;
        }
        return $this->conf->images->base_url . $size . $filepath;
    }
}
