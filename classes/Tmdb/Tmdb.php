<?php

namespace Vfac\Tmdb;

/**
 * Tmdb wrapper core class
 */
class Tmdb
{

    // Private variables
    private $api_key         = null;                              // API Key
    private $language        = 'fr-FR';                           // Default language for API response
    private $base_api_url    = 'https://api.themoviedb.org/3/';   // Base URL of the API
    private $include_adult   = false;                             // Include adult content in search result
    // Protected variables
    protected $response      = null; // Raw response of the API
    protected $configuration = null; // API Configuration
    protected $genres        = null; // API Genres

    /**
     * Constructor
     * @param string $api_key TMDB API Key
     */

    public function __construct($api_key)
    {
        if (!extension_loaded('curl'))
        {
            throw new \Exception('cUrl extension is not loaded', 1003);
        }
        $this->api_key = $api_key;
    }

    /**
     * Send cUrl request to TMDB API
     * @param string $action
     * @param string $query
     * @param array $options
     * @return json string
     */
    private function sendRequest($action, $query = null, $options = array())
    {
        // Url construction
        $url = $this->base_api_url . $action;

        // Parameters
        $params                  = [];
        $params['api_key']       = $this->api_key;
        $params['language']      = $this->language;
        $params['page']          = 1;
        $params['include_adult'] = $this->include_adult;
        if (!is_null($query))
        {
            $params['query'] = $query;
        }

        $params = array_merge($params, $options);

        // URL with paramters construction
        $url = $url . '?' . http_build_query($params);

        // Initialisation
        $ch = curl_init($url);
        if ($ch === false)
        {
            throw new \Exception('cUrl initialisation failed', 1002);
        }

        // cUrl options
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_ENCODING, "");
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        // cUrl execution
        $result = curl_exec($ch);
        if ($result === false)
        {
            throw new \Exception('cUrl failed : ' . var_export(curl_getinfo($ch), true), 1004);
        }
        // cUrl HTTP Code response
        if (curl_getinfo($ch, CURLINFO_HTTP_CODE) !== 200)
        {
            throw new \Exception('Incorrect HTTP Code response : ' . var_export(curl_getinfo($ch), true), 1005);
        }

        // cUrl closing
        curl_close($ch);

        $response = json_decode($result);
        if (is_null($response) || $response === false)
        {
            throw new \Exception('Movie search failed : ' . var_export($this->response, true), 2001);
        }

        return $response;
    }

    /**
     * Set default language code for API response
     * @param string $language
     * @throws Exception
     */
    public function setLanguage($language)
    {
        $check = preg_match("#([a-z]{2})-([A-Z]{2})#", $language);
        if ($check === 0 || $check === false)
        {
            throw new \Exception("Incorrect language code : $language", 1001);
        }

        $this->language = $language;
    }

    /**
     * Get API Configuration
     * @return array
     */
    private function getConfiguration()
    {
        try
        {
            if (is_null($this->configuration))
            {
                $this->configuration = $this->sendRequest('configuration');
            }
            return $this->configuration;
        }
        catch (Exception $ex)
        {
            throw new \Exception($ex->getMessage, $ex->getCode(), $ex);
        }
    }

    /**
     * Search a movie
     * @param string $query
     * @param array $options
     * @return array
     * @throws \Exception
     */
    public function searchMovie($query, array $options = array())
    {
        try
        {
            $params   = $this->checkOptions($options);
            $response = $this->sendRequest('search/movie', $query, $params);

            $result = [];
            foreach ($response->results as $data)
            {
                $data->_conf   = $this->getConfiguration();
                $data->_genres = $this->getMovieGenres();

                $movie = new Movie($data);
                array_push($result, $movie);
            }

            return $result;
        }
        catch (Exception $ex)
        {
            throw new \Exception($ex->getMessage, $ex->getCode(), $ex);
        }
    }

    /**
     * Check options rules before send request
     * @param array $options
     * @return array
     * @throws \Exception
     */
    private function checkOptions(array $options)
    {
        $params = [];
        foreach ($options as $key => $value)
        {
            switch ($key)
            {
                case 'year':
                    $params[$key] = $this->checkYear($value);
                    break;
                case 'language':
                    $params[$key] = $this->checkLanguage($value);
                    break;
                default:
                    throw new \Exception('Unknown options');
            }
        }
        return $params;
    }

    /**
     * Check year format
     * @param mixed $year
     * @return int
     * @throws \Exception
     */
    private function checkYear($year)
    {
        if (!is_numeric($year))
        {
            throw new \Exception('year param must be an integer');
        }
        $year = (int) $year;
        return $year;
    }

    /**
     * Check language format (ISO 639-1)
     * @param string $language
     * @return string
     * @throws \Exception
     */
    private function checkLanguage($language)
    {
        $check = preg_match("#([a-z]{2})-([A-Z]{2})#", $language);
        if ($check === 0 || $check === false)
        {
            throw new \Exception("Incorrect language code : $language", 1001);
        }
        return $language;
    }

    /**
     * Get  movie details
     * @param int $movie_id
     * @param array $options
     * @return \Vfac\Tmdb\Movie
     */
    public function getMovieDetails($movie_id, array $options = array())
    {
        try
        {
            $params          = $this->checkOptions($options);
            $response        = $this->sendRequest('movie/' . (int) $movie_id, null, $params);
            $response->_conf = $this->getConfiguration();

            $result = new Movie($response);
            return $result;
        }
        catch (Exception $ex)
        {
            throw new \Exception($ex->getMessage, $ex->getCode(), $ex);
        }
    }

    /**
     * Search a TV Show
     * @param string $query
     * @param array $options
     * @return array
     */
    public function searchTVShow($query, array $options = array())
    {
        try
        {
            $params   = $this->checkOptions($options);
            $response = $this->sendRequest('search/tv', $query, $params);

            $result = [];
            foreach ($response->results as $data)
            {
                $movie = new TVShow($data);
                array_push($result, $movie);
            }

            return $result;
        }
        catch (Exception $ex)
        {
            throw new \Exception($ex->getMessage, $ex->getCode(), $ex);
        }
    }

    /**
     * Get movie genres list
     * @return array
     */
    private function getMovieGenres()
    {
        try
        {
            if (is_null($this->genres))
            {
                $genres = $this->sendRequest('genre/movie/list');

                $this->genres = [];
                foreach ($genres->genres as $genre)
                {
                    $this->genres[$genre->id] = $genre->name;
                }
            }

            return $this->genres;
        }
        catch (Exception $ex)
        {
            throw new \Exception($ex->getMessage, $ex->getCode(), $ex);
        }
    }

}
