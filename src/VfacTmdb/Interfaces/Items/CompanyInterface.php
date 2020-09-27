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


namespace VfacTmdb\Interfaces\Items;

/**
 * Interface for Company type object
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
interface CompanyInterface
{
    /**
     * Description
     */
    public function getDescription() : string;

    /**
     * Head Quarters
     */
    public function getHeadQuarters() : string;

    /**
     * Home Page
     */
    public function getHomePage() : string;

    /**
     * Id
     */
    public function getId() : int;

    /**
     * Image logo path
     */
    public function getLogoPath() : string;

    /**
     * Name
     */
    public function getName() : string;
}
