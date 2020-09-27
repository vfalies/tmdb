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


namespace VfacTmdb\Results;

use VfacTmdb\Abstracts\Results;
use VfacTmdb\Interfaces\TmdbInterface;

/**
 * Class to manipulate a image result
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
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
     * @param TmdbInterface $tmdb
     * @param int $id
     * @param \stdClass $result
     */
    public function __construct(TmdbInterface $tmdb, int $id, \stdClass $result)
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
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * Aspect ratio
     * @return float
     */
    public function getAspectRatio() : float
    {
        return $this->aspect_ratio;
    }

    /**
     * Image file path
     * @return string
     */
    public function getFilePath() : string
    {
        return $this->file_path;
    }

    /**
     * Height
     * @return int
     */
    public function getHeight() : int
    {
        return $this->height;
    }

    /**
     * Language format ISO 639 1
     * @return string|null
     */
    public function getIso6391() : ?string
    {
        return $this->iso_639_1;
    }

    /**
     * Vote average
     * @return float
     */
    public function getVoteAverage() : float
    {
        return $this->vote_average;
    }

    /**
     * Vote count
     * @return int
     */
    public function getVoteCount() : int
    {
        return $this->vote_count;
    }

    /**
     * Width
     * @return int
     */
    public function getWidth() : int
    {
        return $this->width;
    }
}
