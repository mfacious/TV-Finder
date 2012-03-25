<?php

namespace Tv\EpisodeClients\MissingEpisodes;

class Episode
{
    protected $_season;
    
    protected $_episodeNumber;
    
    protected $_showName;
    
    protected $_showAliases;
    
    public function getSeason()
    {
        return $this->_season;
    }

    public function setSeason($season)
    {
        $this->_season = $season;
    }

    public function getShowName()
    {
        return $this->_showName;
    }

    public function setShowName($showName)
    {
        $this->_showName = $showName;
    }

    public function getShowAliases()
    {
        return $this->_showAliases;
    }

    public function setShowAliases($showAliases)
    {
        $this->_showAliases = $showAliases;
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