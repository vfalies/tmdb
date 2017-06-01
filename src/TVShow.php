<?php

namespace Vfac\Tmdb;

class TVShow implements Interfaces\TVShowInterface
{

    private $id   = null;
    private $tmdb = null;
    private $conf = null;
    private $data = null;

    public function __construct(Tmdb $tmdb, int $tv_id, array $options = array())
    {
        try
        {
            $this->id   = $tv_id;
            $this->tmdb = $tmdb;
            $this->conf = $this->tmdb->getConfiguration();

            // Get tvshow details
            $params     = $this->tmdb->checkOptions($options);
            $this->data = $this->tmdb->sendRequest(new CurlRequest(), 'tv/' . (int) $tv_id, null, $params);
        }
        catch (\Exception $ex)
        {
            throw new \Exception($ex->getMessage(), $ex->getCode(), $ex);
        }
    }

    /**
     * Get TV show id
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function getBackdrop(string $size = 'w780'): string
    {

    }

    public function getGenres(): array
    {
        
    }

    public function getNote(): float
    {

    }

    public function getNumberEpisodes(): int
    {
        
    }

    public function getNumberSeasons(): int
    {

    }

    public function getOriginalTitle(): string
    {
        
    }

    public function getOverview(): string
    {

    }

    public function getPoster(string $size = 'w185'): string
    {
        
    }

    public function getReleaseDate(): string
    {

    }

    public function getStatus(): string
    {
        
    }

    public function getTitle(): string
    {

    }

}
