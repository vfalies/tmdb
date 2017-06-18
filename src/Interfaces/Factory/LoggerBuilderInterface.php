<?php

namespace vfalies\tmdb\Interfaces\Factory;

interface LoggerBuilderInterface extends BuilderInterface
{
    /**
     * @return \Psr\Log\LoggerInterface
     */
    public function getLogger();
}