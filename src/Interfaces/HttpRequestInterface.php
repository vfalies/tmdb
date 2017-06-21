<?php

namespace vfalies\tmdb\Interfaces;

interface HttpRequestInterface
{
    public function getResponse($url);
}
