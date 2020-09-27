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
 * @copyright Copyright (c) 2017-2020
 */


namespace VfacTmdb\Results;

use VfacTmdb\Abstracts\Results;
use VfacTmdb\Interfaces\TmdbInterface;

/**
 * Class to manipulate a logo result
 * @package Tmdb
 * @author Steve Richter <steve@nerdbra.in>
 * @copyright Copyright (c) 2017-2020
 */
class Logo extends Results
{
    /**
     * Id
     * @var int
     */
    protected $id;
    /**
     * Id
     * @var string
     */
    protected $logo_id;
    /**
     * Aspect ratio
     * @var float
     */
    protected $aspect_ratio;
    /**
     * Logo file path
     * @var string
     */
    protected $file_path;
    /**
     * Height
     * @var int
     */
    protected $height;
    /**
     * Original file type
     * @var string
     */
    protected $file_type;
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
        $result->logo_id = $result->id;
        $result->id      = $id;
        parent::__construct($tmdb, $result);

        $this->id           = $result->id;
        $this->logo_id      = $result->logo_id;
        $this->aspect_ratio = $result->aspect_ratio;
        $this->file_path    = $result->file_path;
        $this->height       = $result->height;
        $this->file_type    = $result->file_type;
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
     * Logo file path
     * @param bool $svg
     * @return string
     */
    public function getFilePath(bool $svg = true) : string
    {
        if ($svg === true && $this->file_type === '.svg') {
            return substr($this->file_path, 0, -3) . 'svg';
        }

        return $this->file_path;
    }

    /**
     * Original file type
     * @return string
     */
    public function getFileType() : string
    {
        return $this->file_type;
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
     * Id
     * @return string
     */
    public function getLogoId() : string
    {
        return $this->logo_id;
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
