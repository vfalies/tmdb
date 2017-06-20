<?php

namespace vfalies\tmdb;

use vfalies\tmdb\Tmdb;
use vfalies\tmdb\Exceptions\NotFoundException;
use vfalies\tmdb\Exceptions\IncorrectParamException;

class Media
{

    protected $tmdb   = null;
    protected $conf   = null;
    protected $logger = null;

    /**
     * Constructor
     * @param Tmdb $tmdb
     */
    public function __construct(Tmdb $tmdb)
    {
        $this->tmdb   = $tmdb;
        $this->logger = $tmdb->logger;
        $this->conf   = $this->tmdb->getConfiguration();
    }

    /**
     * Get backdrop url
     * @param string $path
     * @param string $size
     * @return string|null
     */
    public function getBackdropUrl(string $path, string $size = 'w780'): string
    {
        return $this->getImage('backdrop', $size, $path);
    }

    /**
     * Get poster url
     * @param string $path
     * @param string $size
     * @return string
     */
    public function getPosterUrl(string $path, string $size = 'w185'): string
    {
        return $this->getImage('poster', $size, $path);
    }

    /**
     * Get logos url
     * @param string $path
     * @param string $size
     * @return string
     */
    public function getlogoUrl(string $path, string $size = 'w92'): string
    {
        return $this->getImage('logo', $size, $path);
    }

    /**
     * Get profile url
     * @param string $path
     * @param string $size
     * @return string
     */
    public function getProfileUrl(string $path, string $size = 'w185'): string
    {
        return $this->getImage('profile', $size, $path);
    }

    /**
     * Get poster url
     * @param string $path
     * @param string $size
     * @return string
     */
    public function getStillUrl(string $path, string $size = 'w185'): string
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
    private function getImage(string $type, string $size, string $filepath): string
    {
        if (!isset($this->conf->images->base_url)) {
            $this->logger->error('No image base url found from configuration');
            throw new NotFoundException;
        }
        $sizes = $type . '_sizes';
        if (!in_array($size, $this->conf->images->$sizes)) {
            $this->logger->error('Incorrect param image size', array('type' => $type, 'size' => $size, 'filepath' => $filepath));
            throw new IncorrectParamException;
        }
        return $this->conf->images->base_url . $size . $filepath;
    }
}
