<?php

namespace Vfac\Tmdb\Interfaces;

interface TmdbInterface
{

    /**
     * Send cUrl request to TMDB API
     * @param HttpRequestInterface $http_request
     * @param string $action API action to request
     * @param string $query Query of the request (optional)
     * @param array $options Array of options of the request (optional)
     * @return \stdClass
     */
    public function sendRequest(HttpRequestInterface $http_request, string $action, string $query = null, array $options = array()): \stdClass;

    /**
     * Get API Configuration
     * @return \stdClass
     */
    public function getConfiguration(): \stdClass;

    /**
     * Check options rules before send request
     * @param array $options Array of options to validate
     * @return array
     * @throws \Exception
     */
    public function checkOptions(array $options): array;
}
