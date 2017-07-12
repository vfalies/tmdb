<?php
/**
 * This file is part of the Tmdb package.
 *
 * (c) Vincent Faliès <vincent.falies@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *

 * @author Vincent Faliès <vincent.falies@gmail.com>
 * @copyright Copyright (c) 2017
 */


namespace vfalies\tmdb\Results;

use vfalies\tmdb\Abstracts\Results;
use vfalies\tmdb\Interfaces\TmdbInterface;

/**
 * Class to manipulate a image result
 * @package Tmdb
 * @author Vincent Faliès <vincent.falies@gmail.com>
 * @copyright Copyright (c) 2017
 */
class Image extends Results
{
    /**
     * Id
     * @var int
     */
    protected $id;
    /**
     * Aspect ratio
     * @var float
     */
    protected $aspect_ratio;
    /**
     * Image file path
     * @var string
     */
    protected $file_path;
    /**
     * Height
     * @var int
     */
    protected $height;
    /**
     * Language format ISO 639 1
     * @var string
     */
    protected $iso_639_1;
    /**
     * Vote Average
     * @var float
     */
    protected $vote_average;
    /**
     * Vote count
     * @var int
     */
    protected $vote_count;
    /**
     * Width
     * @var int
     */
    protected $width;

    /**
     * Constructor
     * @param \vfalies\tmdb\Interfaces\TmdbInterface $tmdb
     * @param int $id
     * @param \stdClass $result
     */
    public function __construct(TmdbInterface $tmdb, $id, \stdClass $result)
    {
        $result->id = $id;
        parent::__construct($tmdb, $result);

        $this->id           = (int) $id;
        $this->aspect_ratio = $result->aspect_ratio;
        $this->file_path    = $result->file_path;
        $this->height       = $result->height;
        $this->iso_639_1    = $result->iso_639_1;
        $this->vote_average = $result->vote_average;
        $this->vote_count   = $result->vote_count;
        $this->width        = $result->width;
    }

    /**
     * Id
     * @return int
     */
    public function getId()
    {
        return (int) $this->id;
    }

    /**
     * Aspect ratio
     * @return float
     */
    public function getAspectRatio()
    {
        return $this->aspect_ratio;
    }

    /**
     * Image file path
     * @return string
     */
    public function getFilePath()
    {
        return $this->file_path;
    }

    /**
     * Height
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Language format ISO 639 1
     * @return string
     */
    public function getIso6391()
    {
        return $this->iso_639_1;
    }

    /**
     * Vote average
     * @return float
     */
    public function getVoteAverage()
    {
        return $this->vote_average;
    }

    /**
     * Vote count
     * @return int
     */
    public function getVoteCount()
    {
        return $this->vote_count;
    }

    /**
     * Width
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

}
