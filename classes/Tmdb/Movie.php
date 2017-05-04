<?php

namespace Vfac\Tmdb;

require 'Tmdb.php';

class Movie extends \Vfac\Tmdb\Tmdb
{

    public function getMovie($query, $year = null)
    {
        $raw      = $this->sendRequest('search/movie', $query, $year);
        $response = json_decode($raw);

        if (is_null($response) || $response === false)
        {
            throw new Exception('Movie search failed : ' . var_export($this->response, true), 2001);
        }

        $this->query['query'] = $query;
        $this->query['info']  = $year;
        $this->response       = $response;

        return $this;
    }

// SUCCESS

    /*
     * {
      "adult": false,
      "backdrop_path": "/wSJPjqp2AZWQ6REaqkMuXsCIs64.jpg",
      "belongs_to_collection": null,
      "budget": 63000000,
      "genres": [
      {
      "id": 18,
      "name": "Drama"
      }
      ],
      "homepage": "http://www.foxmovies.com/movies/fight-club",
      "id": 550,
      "imdb_id": "tt0137523",
      "original_language": "en",
      "original_title": "Fight Club",
      "overview": "A ticking-time-bomb insomniac and a slippery soap salesman channel primal male aggression into a shocking new form of therapy. Their concept catches on, with underground \"fight clubs\" forming in every town, until an eccentric gets in the way and ignites an out-of-control spiral toward oblivion.",
      "popularity": 11.628088,
      "poster_path": "/adw6Lq9FiC9zjYEpOqfq03ituwp.jpg",
      "production_companies": [
      {
      "name": "Regency Enterprises",
      "id": 508
      },
      {
      "name": "Fox 2000 Pictures",
      "id": 711
      },
      {
      "name": "Taurus Film",
      "id": 20555
      },
      {
      "name": "Linson Films",
      "id": 54050
      },
      {
      "name": "Atman Entertainment",
      "id": 54051
      },
      {
      "name": "Knickerbocker Films",
      "id": 54052
      }
      ],
      "production_countries": [
      {
      "iso_3166_1": "DE",
      "name": "Germany"
      },
      {
      "iso_3166_1": "US",
      "name": "United States of America"
      }
      ],
      "release_date": "1999-10-15",
      "revenue": 100853753,
      "runtime": 139,
      "spoken_languages": [
      {
      "iso_639_1": "en",
      "name": "English"
      }
      ],
      "status": "Released",
      "tagline": "How much can you know about yourself if you've never been in a fight?",
      "title": "Fight Club",
      "video": false,
      "vote_average": 8.2,
      "vote_count": 7506
      }
     */

// FAILURE
    /*
      {
      "page": 1,
      "results": [],
      "total_results": 0,
      "total_pages": 1
      }
     */
}
