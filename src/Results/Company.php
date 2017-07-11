<?php

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
