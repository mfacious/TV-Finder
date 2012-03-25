<?php

namespace Tv\EpisodeClients\MissingEpisodes;

interface MissingEpisodeInterface
{
    public function getEpisodeSeason();
    
    public function getEpisodeNumber();
}