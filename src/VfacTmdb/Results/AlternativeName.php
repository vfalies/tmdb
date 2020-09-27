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
 * Class to manipulate a name result
 * @package Tmdb
 * @author Steve Richter <steve@nerdbra.in>
 * @copyright Copyright (c) 2017-2020
 */
class AlternativeName extends Results
{
    /**
     * Id
     * @var int
     */
    protected $id;
    /**
     * Name
     * @var string
     */
    protected $name;
    /**
     * Type
     * @var string
     */
    protected $type;

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
        $this->name         = $result->name;
        $this->type         = $result->type;
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
     * Name
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Type
     * @return string
     */
    public function getType() : string
    {
        return $this->type;
    }
}
