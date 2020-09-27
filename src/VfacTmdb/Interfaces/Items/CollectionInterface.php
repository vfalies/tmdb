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
 * Interface for Collection type object
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
interface CollectionInterface
{

    /**
     * Get collection ID
     * @return int
     */
    public function getId() : int;

    /**
     * Get collection name
     * @return string
     */
    public function getName() : string;

    /**
     * Get collection parts
     * @return \Generator
     */
    public function getParts() : \Generator;

    /**
     * Get poster path
     * @return string
     */
    public function getPosterPath() : string;

    /**
     * Get backdrop path
     * @return string
     */
    public function getBackdropPath() : string;
}
