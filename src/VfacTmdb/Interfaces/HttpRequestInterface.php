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
 * @copyright Copyright (c) 2017
 */


namespace VfacTmdb\Interfaces;

/**
 * HTTP Request inferface
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
interface HttpRequestInterface
{
    /**
     * Get response http from specified url
     * @param string $url
     */
    public function getResponse(string $url);

    /**
     * Post response method
     * @param  string $url
     * @param  array  $options
     * @param  array $form_params
     * @return mixed
     */
    public function postResponse(string $url, array $options = [], array $form_params = array());

    /**
     * Delete response method
     * @param string $url
     * @return mixed
     */
    public function deleteResponse(string $url);
}
