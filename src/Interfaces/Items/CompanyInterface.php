<?php
/**
 * This file is part of the Tmdb package.
 *
 * (c) Vincent Faliès <vincent.falies@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *

 * @author Vincent Faliès <vincent.falies@gmail.com>
 * @copyright Copyright (c) 2017
 */


namespace vfalies\tmdb\Interfaces\Items;

/**
 * Interface for Company type object
 * @package Tmdb
 * @author Vincent Faliès <vincent.falies@gmail.com>
 * @copyright Copyright (c) 2017
 */
interface CompanyInterface
{
    /**
     * Description
     */
    public function getDescription();

    /**
     * Head Quarters
     */
    public function getHeadQuarters();

    /**
     * Home Page
     */
    public function getHomePage();

    /**
     * Id
     */
    public function getId();

    /**
     * Image logo path
     */
    public function getLogoPath();

    /**
     * Name
     */
    public function getName();
}
