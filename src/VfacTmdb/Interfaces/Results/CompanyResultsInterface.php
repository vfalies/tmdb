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


namespace VfacTmdb\Interfaces\Results;

/**
 * Interface for Company results type object
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
interface CompanyResultsInterface extends ResultsInterface
{

    /**
     * Get company name
     * @return string
     */
    public function getName() : string;

    /**
     * Get company logo path
     * @return string|null
     */
    public function getLogoPath() : ?string;
}
