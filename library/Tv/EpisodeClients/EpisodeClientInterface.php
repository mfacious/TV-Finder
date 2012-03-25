<?php

namespace Tv\EpisodeClients;

interface EpisodeClientInterface
{
    public function getMissingEpisodes(
            $name, 
            array $aliases, 
            array $existingEpisodes
    );
}