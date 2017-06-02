<?php

namespace vfalies\tmdb;

class CurlRequest implements Interfaces\HttpRequestInterface
{

    private $handle = null;

    /**
     * Set the url to cUrl call
     * @param string $url
     * @throws Exception
     */
    public function setUrl(string $url): void
    {
        $this->handle = curl_init($url);
    }

    /**
     * Close cUrl handle
     */
    public function close(): void
    {
        curl_close($this->handle);
    }

    /**
     * Execute cUrl call
     * @return mixed
     * @throws \Exception
     */
    public function execute()
    {
        $result = curl_exec($this->handle);
        if ($result === false)
        {
            throw new \Exception('cUrl failed : '.var_export($this->getInfo(), true), 1004);
        }
        return $result;
    }

    /**
     * Get cUrl infos
     * @param string $name
     * @return mixed
     * @throws Exception
     */
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
        return $info;
    }

    /**
     * Set cUrl option
     * @param string $name
     * @param string $value
     * @throws \Exception
     */
    public function setOption(string $name, string $value): Interfaces\HttpRequestInterface
    {
        curl_setopt($this->handle, $name, $value);
        return $this;
    }

    /**
     * Magical getter
     * @param string $name
     * @return mixed
     */
    public function __get(string $name)
    {
        switch ($name)
        {
            case 'handle':
                $response = $this->$name;
                break;
        }
        return $response;
    }
}
