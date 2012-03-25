<?php

define('DOWNLOAD_DIR', '/home/tom/Videos');


require('library/autoloader.php');

$showSearcher = new Tv\Searchers\FileSearcher(DOWNLOAD_DIR);

$downloadSearchClients = array(
    new Tv\DownloadClients\HdBits()
);

$episodeClients = array(
    new Tv\EpisodeClients\EpisodeGuess()
);

$showFinder = new Tv\TVSearch(
        $showSearcher, 
        $downloadSearchClients,
        $episodeClients
);

$showFinder->run();