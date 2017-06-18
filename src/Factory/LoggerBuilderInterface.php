<?php

namespace vfalies\tmdb\Factory;

interface LoggerBuilderInterface extends BuilderInterface
{
    /**
     * @return \Psr\Log\LoggerInterface
     */
    public function getLogger();
}