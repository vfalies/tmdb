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
use VfacTmdb\Interfaces\Results\CollectionResultsInterface;
use VfacTmdb\Traits\ElementTrait;
use VfacTmdb\Interfaces\TmdbInterface;

/**
 * Class to manipulate a collection result
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
class Collection extends Results implements CollectionResultsInterface
{
    use ElementTrait;

    /**
     * Collection name
     * @var string
     */
    protected $name = null;
    /**
     * Image poster path
     * @var string
     */
    protected $poster_path = null;
    /**
     * Image backdrop path
     * @var string
     */
    protected $backdrop_path = null;
    /**
     * Id
     * @var int
     */
    protected $id = null;

    /**
     * Constructor
     * @param TmdbInterface $tmdb
     * @param \stdClass $result
     */
    public function __construct(TmdbInterface $tmdb, \stdClass $result)
    {
        parent::__construct($tmdb, $result);

        // Populate data
        $this->id            = $this->data->id;
        $this->name          = $this->data->name;
        $this->poster_path   = $this->data->poster_path;
        $this->backdrop_path = $this->data->backdrop_path;

        $this->setElementTrait($this->data);
    }

    /**
     * Get collection ID
     * @return int
     */
    public function getId() : int
    {
        return (int) $this->id;
    }

    /**
     * Get collection name
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }
}
