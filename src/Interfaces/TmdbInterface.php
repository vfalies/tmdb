<?php

namespace vfalies\tmdb\Interfaces;

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
    public function sendRequest(HttpRequestInterface $http_request, $action, $query = null, array $options = array());

    /**
     * Get API Configuration
     * @return \stdClass
     */
    public function getConfiguration();

    /**
     * Check options rules before send request
     * @param array $options Array of options to validate
     * @return array
     */
    public function checkOptions(array $options);
}
