<?php

namespace vfalies\tmdb\Interfaces\Items;

interface CompanyInterface
{
    public function getDescription();

    public function getHeadQuarters();

    public function getHomePage();

    public function getId();

    public function getLogoPath();

    public function getName();
}
