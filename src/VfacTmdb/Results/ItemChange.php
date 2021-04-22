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
 * @copyright Copyright (c) 2017-2021
 */

namespace VfacTmdb\Results;

use VfacTmdb\Abstracts\Results;
use VfacTmdb\Interfaces\TmdbInterface;
use VfacTmdb\Interfaces\Results\ItemChangeResultsInterface;

/**
 * Class to manipulate an ItemChange result
 * @package Tmdb
 * @author Steve Richter <steve@nerdbra.in>
 * @copyright Copyright (c) 2021
 */
class ItemChange extends Results implements ItemChangeResultsInterface
{
    /**
     * Id
     * @var string
     */
    protected $id;
    /**
     * Key
     * @var string
     */
    protected $key;
    /**
     * Action
     * @var string
     */
    protected $action;
    /**
     * Time
     * @var string
     */
    protected $time;
    /**
     * iso_639_1
     * @var string
     */
    protected $iso_639_1 = null;
    /**
     * iso_3166_1
     * @var string
     */
    protected $iso_3166_1 = null;
    /**
     * Value
     * @var array
     */
    protected $value;
    /**
     * Original value
     * @var array
     */
    protected $original_value;

    /**
     * Constructor
     * @param TmdbInterface $tmdb
     * @param \stdClass $result
     */
    public function __construct(TmdbInterface $tmdb, \stdClass $result)
    {
        $result = $this->initResultObject($result);

        parent::__construct($tmdb, $result);

        // Populate data
        $this->id             = $this->data->id;
        $this->key            = $this->data->key;
        $this->action         = $this->data->action;
        $this->time           = $this->data->time;
        $this->iso_639_1      = $this->data->iso_639_1;
        $this->iso_3166_1     = $this->data->iso_3166_1;
        $this->value          = $this->data->value;
        $this->original_value = $this->data->original_value;
    }

    /**
     * initResultObject
     * @param  \stdClass  $result
     * @return \stdClass
     */
    private function initResultObject(\stdClass $result) : \stdClass
    {
        foreach (['value', 'original_value'] as $key) {
            if (!isset($result->{$key})) {
                $result->{$key} = [];
            }
            if (is_object($result->{$key})) {
                $result->{$key} = get_object_vars($result->{$key});
            }
            if (!is_array($result->{$key})) {
                $result->{$key} = [$result->{$key}];
            }
        }
        return $result;
    }

    /**
     * Get Id
     * @return string
     */
    public function getId() : string
    {
        return $this->id;
    }

    /**
     * Get key
     * @return string
     */
    public function getKey() : string
    {
        return $this->key;
    }

    /**
     * Get action
     * @return string
     */
    public function getAction() : string
    {
        return $this->action;
    }

    /**
     * Get time
     * @return \DateTime
     */
    public function getTime() : \DateTime
    {
        return \DateTime::createFromFormat('Y-m-d H:i:s e', $this->time);
    }

    /**
     * Get iso_639_1
     * @return  string
     */
    public function getIso_639_1() : string
    {
        return $this->iso_639_1;
    }

    /**
     * Get iso_3166_1
     * @return  string
     */
    public function getIso_3166_1() : string
    {
        return $this->iso_3166_1;
    }

    /**
     * Get value
     * @return  array
     */
    public function getValue() : array
    {
        return $this->value;
    }

    /**
     * Get original value
     * @return  array
     */
    public function getOriginalValue() : array
    {
        return $this->original_value;
    }

    /**
     * Get value by key
     * @param   string  $key
     * @return  mixed
     */
    public function getValueByKey($key)
    {
        return $this->value[$key] ?? null;
    }
}
