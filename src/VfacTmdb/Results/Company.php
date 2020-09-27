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
use VfacTmdb\Interfaces\Results\CompanyResultsInterface;
use VfacTmdb\Interfaces\TmdbInterface;

/**
 * Class to manipulate a company result
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
class Company extends Results implements CompanyResultsInterface
{
    /**
     * Collection name
     * @var string
     */
    protected $name = null;
    /**
     * Collection image logo path
     * @var string
     */
    protected $logo_path = null;
    /**
     * Collection Id
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
        $this->id        = $this->data->id;
        $this->name      = $this->data->name;
        $this->logo_path = $this->data->logo_path;
    }

    /**
     * Collection id
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * Image logo path
     * @return string|null
     */
    public function getLogoPath() : ?string
    {
        return $this->logo_path;
    }

    /**
     * Collection name
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }
}
