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


namespace vfalies\tmdb\Interfaces;

/**
 * Tmdb interface
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
interface TmdbInterface
{

    /**
     * Send cUrl request to TMDB API
     * @param string $action API action to request
     * @param string $query Query of the request (optional)
     * @param array $options Array of options of the request (optional)
     * @return \stdClass
     */
    public function getRequest($action, $query = null, array $options = array());

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

    /**
     * Get current logger
     * @return \Psr\Log\LoggerInterface
     */
    public function getLogger();
}
