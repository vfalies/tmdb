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
use vfalies\tmdb\Interfaces\Results\CompanyResultsInterface;

/**
 * Class to manipulate a company result
 * @package Tmdb
 * @author Vincent Faliès <vincent.falies@gmail.com>
 * @copyright Copyright (c) 2017
 */
class Company extends Results implements CompanyResultsInterface
{
    /**
     * Collection name
     * @var string
     */
    protected $name      = null;
    /**
     * Collection image logo path
     * @var string
     */
    protected $logo_path = null;
    /**
     * Collection Id
     * @var int
     */
    protected $id        = null;

    /**
     * Constructor
     * @param \vfalies\tmdb\Tmdb $tmdb
     * @param \stdClass $result
     */
    public function __construct(Tmdb $tmdb, \stdClass $result)
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
    public function getId()
    {
        return $this->id;
    }

    /**
     * Image logo path
     * @return string
     */
    public function getLogoPath()
    {
        return $this->logo_path;
    }

    /**
     * Collection name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

}
