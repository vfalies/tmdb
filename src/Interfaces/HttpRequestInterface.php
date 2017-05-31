<?php

namespace Vfac\Tmdb\Interfaces;

interface HttpRequestInterface
{
    public function setUrl(string $url) : void;

    public function setOption(string $name, string $value) : void;

    public function execute();

    public function getInfo(string $name);

    public function close() : void;
}