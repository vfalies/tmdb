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


namespace VfacTmdb\Traits\Results;

/**
 * Trait with methods for Show (Movie & TVShow)
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
trait ShowTrait
{
    /**
     * Id
     * @var int
     */
    protected $id;
    /**
     * Overview
     * @var string
     */
    protected $overview;
    /**
     * Release date
     * @var string
     */
    protected $release_date;
    /**
     * Original title
     * @var string
     */
    protected $original_title;
    /**
     * Title
     * @var string
     */
    protected $title;

    /**
     * Get show ID
     * @return int
     */
    public function getId() : int
    {
        return (int) $this->id;
    }

    /**
     * Get show overview
     * @return string
     */
    public function getOverview() : string
    {
        return $this->overview;
    }

    /**
     * Get show first air date
     * @return string
     */
    public function getReleaseDate() : string
    {
        return $this->release_date;
    }

    /**
     * Get show original name
     * @return string
     */
    public function getOriginalTitle() : string
    {
        return $this->original_title;
    }

    /**
     * Get show name
     * @return string
     */
    public function getTitle() : string
    {
        return $this->title;
    }
}
