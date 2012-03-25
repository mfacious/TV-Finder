<?php

namespace Tv\EpisodeClients;

class EpisodeGuess implements EpisodeClientInterface
{
    public function getMissingEpisodes(
                                        $name, 
                                        array $aliases, 
                                        array $existingEpisodes
    )
    {
        var_dump($existingEpisodes);
        die();
        foreach($existingEpisodes as $episode)
        {
            
        }
    }
}