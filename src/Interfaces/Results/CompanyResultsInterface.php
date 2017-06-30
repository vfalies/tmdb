<?php

namespace vfalies\tmdb\Interfaces\Results;

interface CompanyResultsInterface extends ResultsInterface
{

    /**
     * Get company name
     * @return string
     */
    public function getName();

    /**
     * Get company logo path
     * @return string
     */
    public function getLogoPath();

}
