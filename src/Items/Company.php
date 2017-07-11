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


namespace vfalies\tmdb\Items;

use vfalies\tmdb\Abstracts\Item;
use vfalies\tmdb\Interfaces\Items\CompanyInterface;
use vfalies\tmdb\Tmdb;
use vfalies\tmdb\lib\Guzzle\Client as HttpClient;
use vfalies\tmdb\Traits\ElementTrait;

/**
 * Company class
 * @author Vincent Faliès <vincent.falies@gmail.com>
 * @copyright Copyright (c) 2017
 */
class Company extends Item implements CompanyInterface
{
    use ElementTrait;

    /**
     * Constructor
     * @param \vfalies\tmdb\Tmdb $tmdb
     * @param int $company_id
     * @param array $options
     */
    public function __construct(Tmdb $tmdb, $company_id, array $options = array())
    {
        parent::__construct($tmdb, $company_id, $options, 'company');
    }

    /**
     * Company description
     * @return string
     */
    public function getDescription()
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
    public function getHeadQuarters()
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
    public function getHomePage()
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
    public function getId()
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
    public function getLogoPath()
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
    public function getName()
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
    public function getMovies()
    {
        $data = $this->tmdb->sendRequest(new HttpClient(new \GuzzleHttp\Client()), '/company/'.(int) $this->id.'/movies', null, $this->params);

        foreach ($data->results as $m)
        {
            $movie = new \vfalies\tmdb\Results\Movie($this->tmdb, $m);
            yield $movie;
        }
    }
}
