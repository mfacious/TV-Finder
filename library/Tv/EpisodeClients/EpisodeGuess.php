<?php

namespace Tv\EpisodeClients;

class EpisodeGuess implements EpisodeClientInterface
{
    public function getMissingEpisodes(
        $name, array $aliases, array $existingEpisodes
    )
    {
        $topSeries = 0;
        $topEpisode = 0;
        foreach($existingEpisodes as $episode)
        {
            $series = $episode['series'];
            $episode = $episode['episode'];
            
            if((int) $series >= $topSeries)
            {
                $topSeries = $series;
                
                if((int) $episode > $topEpisode)
                {
                    $topEpisode = $episode;
                }
            }
        }
        
        // Now that we have the current top Episode on file system
        // Then we want to generate three possible missing episodes.
        // The first is The current episode and series +1
        // the second is the current ep and series +2
        // The third is the next season +1 and Episode 1.
        
        $firstMissing = new MissingEpisodes\Episode();
        
        $firstMissing->setEpisodeNumber($topEpisode + 1);
        $firstMissing->setSeason($topSeries);
        
        $secondMissing = new MissingEpisodes\Episode();
        
        $secondMissing->setEpisodeNumber($topEpisode + 2);
        $secondMissing->setSeason($topSeries);
        
        $thirdMissing = new MissingEpisodes\Episode();
        
        $thirdMissing->setEpisodeNumber(1);
        $thirdMissing->setSeason($topSeries + 1);
        
        $missing = array($firstMissing, $secondMissing, $thirdMissing);
        
        foreach($missing as $missingEpisode)
        {
            $missingEpisode->setShowName($name);
            $missingEpisode->setShowAliases($aliases);
        }
        
        return $missing;
        
    }
}