<?php

namespace Vfac\Tmdb\Interfaces;

interface Results
{

    /**
     * Get  ID
     * @return int
     */
    public function getId();

    /**
     * Get movie overview
     * @return string
     */
    public function getOverview();

    /**
     * Get movie release date
     * @return string
     */
    public function getReleaseDate();

    /**
     * Get movie original title
     * @return string
     */
    public function getOriginalTitle();

    /**
     * Get movie title
     * @return string
     */
    public function getTitle();

    /**
     * Get movie poster
     * @return string
     */
    public function getPoster();

    /**
     * Get movie backdrop
     * @return string
     */
    public function getBackdrop();
}
