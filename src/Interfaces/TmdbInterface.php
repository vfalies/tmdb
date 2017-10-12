<?php
/**
 * This file is part of the Tmdb package.
 *
 * (c) Vincent Faliès <vincent@vfac.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */


namespace VfacTmdb\Interfaces;

/**
 * Tmdb interface
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
interface TmdbInterface
{

    /**
     * Send cUrl request to TMDB API with GET Http method
     * @param string $action API action to request
     * @param array $options Array of options of the request (optional)
     * @return \stdClass|null
     */
    public function getRequest(string $action, array $options = array()) : ?\stdClass;

    /**
     * Send cUrl request to TMDB API with POST Http method
     * @param string $action API action to request
     * @param array $options Array of options of the request (optional)
     * @return \stdClass|null
     */
    public function postRequest(string $action, array $options = array()) : ?\stdClass;

    /**
     * Get API Configuration
     * @return \stdClass
     */
    public function getConfiguration() : \stdClass;

    /**
     * Check options rules before send request
     * @param array $options Array of options to validate
     * @return array
     */
    public function checkOptions(array $options) : array;

    /**
     * Get current logger
     * @return \Psr\Log\LoggerInterface
     */
    public function getLogger() : \Psr\Log\LoggerInterface;
}
