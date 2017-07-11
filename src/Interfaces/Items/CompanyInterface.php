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

interface CompanyInterface
{
    public function getDescription();

    public function getHeadQuarters();

    public function getHomePage();

    public function getId();

    public function getLogoPath();

    public function getName();
}
