<?php

namespace Vfac\Tmdb;

class CurlRequest implements Interfaces\HttpRequestInterface
{

    private $handle = null;

    public function setUrl(string $url): void
    {
        $this->handle = curl_init($url);
        if (!$this->handle)
        {
            throw new Exception('Curl init failed');
        }
    }

    public function close(): void
    {
        curl_close($this->handle);
    }

    public function execute()
    {
        $result = curl_exec($this->handle);
        if ($result === false)
        {
            throw new \Exception('cUrl failed : '.var_export($this->getInfo(), true), 1004);
        }
        return $return;
    }

    public function getInfo(string $name = '')
    {
        if (empty($name))
        {
            $info = curl_getinfo($this->handle);
        }
        else
        {
            $info = curl_getinfo($this->handle, $name);
        }
        if ($info === false)
        {
            throw new Exception('cUrl get info failed');
        }
        return $info;
    }

    public function setOption(string $name, string $value): void
    {
        if (!curl_setopt($this->handle, $name, $value))
        {
            throw new \Exception('cUrl set option failed');
        }
    }

}
