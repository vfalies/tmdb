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
use vfalies\tmdb\Tmdb;

class Image extends Results
{

    protected $id;
    protected $aspect_ratio;
    protected $file_path;
    protected $height;
    protected $iso_639_1;
    protected $vote_average;
    protected $vote_count;
    protected $width;

    public function __construct(Tmdb $tmdb, $id, \stdClass $result)
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

    public function getId()
    {
        return (int) $this->id;
    }

    public function getAspectRatio()
    {
        return $this->aspect_ratio;
    }

    public function getFilePath()
    {
        return $this->file_path;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function getIso6391()
    {
        return $this->iso_639_1;
    }

    public function getVoteAverage()
    {
        return $this->vote_average;
    }

    public function getVoteCount()
    {
        return $this->vote_count;
    }

    public function getWidth()
    {
        return $this->width;
    }

}
