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


namespace VfacTmdb\Interfaces\Items;

/**
 * Interface for TVNetwork type object
 * @package Tmdb
 * @author Steve Richter <steve@nerdbra.in>
 * @copyright Copyright (c) 2017-2020
 */
interface TVNetworkInterface
{

    /**
     * Id
     * @return int
     */
    public function getId() : int;

    /**
     * Name
     * @return string
     */
    public function getName() : string;

    /**
     * Headquarters
     * @return string
     */
    public function getHeadquarters() : string;

    /**
     * Homepage
     * @return string
     */
    public function getHomepage() : string;

    /**
     * Origin country
     * @return string
     */
    public function getOriginCountry() : string;

    /**
     * Logos list
     * @return \Generator
     */
    public function getLogos() : \Generator;

    /**
     * Alternative names list
     * @return \Generator
     */
    public function getAlternativeNames() : \Generator;
}
