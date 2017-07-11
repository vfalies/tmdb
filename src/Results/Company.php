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

class Company extends Results implements CompanyResultsInterface
{

    protected $name      = null;
    protected $logo_path = null;
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

    public function getId()
    {
        return $this->id;
    }

    public function getLogoPath()
    {
        return $this->logo_path;
    }

    public function getName()
    {
        return $this->name;
    }

}
