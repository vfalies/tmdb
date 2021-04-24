<?php declare(strict_types=1);
/**
 * This file is part of the Tmdb package.
 *
 * (c) Vincent Faliès <vincent@vfac.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017-2020
 */


namespace VfacTmdb\Interfaces;

/**
 * Tmdb interface
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017-2020
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
     * @param array $form_params form_params for request options
     * @return \stdClass|null
     */
    public function postRequest(string $action, array $options = array(), array $form_params = array()) : ?\stdClass;

    /**
     * Send request to TMDB API with DELETE method
     * @param  string $action  API action to request
     * @param  array  $options Array of options of the request (optional)
     * @return \stdClass|null
     */
    public function deleteRequest(string $action, array $options = array()) : ?\stdClass;

    /**
     * Get API Configuration
     * @return \stdClass
     * @throws TmdbException
     */
    public function getConfiguration() : \stdClass;

    /**
     * Get current logger
     * @return \Psr\Log\LoggerInterface
     */
    public function getLogger() : \Psr\Log\LoggerInterface;

    /**
     * Check Language string with format ISO 639-1
     * @param array $options
     * @param array &$return Return array to save valid option
     * @return void
     */
    public function checkOptionLanguage(array $options, array &$return) : void;

    /**
     * Check year option and return correct value
     * @param array $options
     * @param array &$return Return array to save valid option
     * @return void
     */
    public function checkOptionYear(array $options, array &$return) : void;

    /**
     * Check page option
     * @param  array  $options
     * @param array &$return Return array to save valid option
     * @return void
     */
    public function checkOptionPage(array $options, array &$return) : void;

    /**
     * Check session_id option
     * @param array  $options
     * @param array &$return Return array to save valid option
     * @return void
     */
    public function checkOptionSessionId(array $options, array &$return) : void;

    /**
     * Check sort by option
     * @param  array  $options
     * @param array &$return Return array to save valid option
     * @return void
     */
    public function checkOptionSortBy(array $options, array &$return) : void;

    /**
     * Check query option
     * @param  array  $options
     * @param array &$return Return array to save valid option
     * @return void
     */
    public function checkOptionQuery(array $options, array &$return) : void;

    /**
     * Check include adult option
     * @param  array $options
     * @param array &$return Return array to save valid option
     * @return void
     */
    public function checkOptionIncludeAdult(array $options, array &$return) : void;

    /**
     * Check external_source option
     * @param array $options
     * @param array $return Return array to save valid option
     * @return void
     */
    public function checkOptionExternalSource(array $options, array &$return) : void;

    /**
     * Check date option
     * @param  string $option
     * @return bool
     * @author Steve Richter <steve@nerdbra.in>
     */
    public function checkOptionDate(string $option) : bool;

    /**
     * Check date range options
     * @param  array $options
     * @param array &$return Return array to save valid options
     * @return void
     * @throws IncorrectParamException
     * @author Steve Richter <steve@nerdbra.in>
     */
    public function checkOptionDateRange(array $options, array &$return) : void;
}
