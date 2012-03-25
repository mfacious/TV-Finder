<?php

namespace Tv\EpisodeClients\MissingEpisodes;

class Episode implements MissingEpisodeInterface
{
    protected $_season;
    
    protected $_episodeNumber;
    
    public function getEpisodeSeason()
    {
        return $this->_season;
    }

    public function setEpisodeSeason($season)
    {
        $this->_season = $season;
    }

    public function getEpisodeNumber()
    {
        return $this->_episodeNumber;
    }

    public function setEpisodeNumber($episodeNumber)
    {
        $this->_episodeNumber = $episodeNumber;
    }


}