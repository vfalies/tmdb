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


namespace VfacTmdb\Items;

use VfacTmdb\Abstracts\Item;
use VfacTmdb\Interfaces\Items\CompanyInterface;
use VfacTmdb\Results;
use VfacTmdb\Traits\ElementTrait;
use VfacTmdb\Interfaces\TmdbInterface;

/**
 * Company class
 * @package Tmdb
 * @author Vincent Faliès <vincent@vfac.fr>
 * @copyright Copyright (c) 2017
 */
class Company extends Item implements CompanyInterface
{
    use ElementTrait;

    /**
     * Constructor
     * @param TmdbInterface $tmdb
     * @param int $company_id
     * @param array $options
     */
    public function __construct(TmdbInterface $tmdb, int $company_id, array $options = array())
    {
        parent::__construct($tmdb, $company_id, $options, 'company');

        $this->setElementTrait($this->data);
    }

    /**
     * Company description
     * @return string
     */
    public function getDescription() : string
    {
        if (isset($this->data->description)) {
            return $this->data->description;
        }
        return '';
    }

    /**
     * Company Head quarters
     * @return string
     */
    public function getHeadQuarters() : string
    {
        if (isset($this->data->headquarters)) {
            return $this->data->headquarters;
        }
        return '';
    }

    /**
     * Company Homepage
     * @return string
     */
    public function getHomePage() : string
    {
        if (isset($this->data->homepage)) {
            return $this->data->homepage;
        }
        return '';
    }

    /**
     * Company Id
     * @return int
     */
    public function getId() : int
    {
        if (isset($this->data->id)) {
            return $this->data->id;
        }
        return 0;
    }

    /**
     * Company image logo path
     * @return string
     */
    public function getLogoPath() : string
    {
        if (isset($this->data->logo_path)) {
            return $this->data->logo_path;
        }
        return '';
    }

    /**
     * Company name
     * @return string
     */
    public function getName() : string
    {
        if (isset($this->data->name)) {
            return $this->data->name;
        }
        return '';
    }

    /**
     * Company movies list
     * @return \Generator|Results\Movie
     */
    public function getMovies() : \Generator
    {
        $params = [];
        $this->tmdb->checkOptionLanguage($this->params, $params);
        $data = $this->tmdb->getRequest('company/' . (int) $this->id . '/movies', $params);

        foreach ($data->results as $m) {
            $movie = new Results\Movie($this->tmdb, $m);
            yield $movie;
        }
    }
}
