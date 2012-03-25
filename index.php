<?php

define('DOWNLOAD_DIR', '/home/tom/Videos');


require('library/autoloader.php');

$showSearcher = new Tv\Searchers\FileSearcher(DOWNLOAD_DIR);

$downloadSearchClients = array(
    new Tv\Clients\HdBits()
);



$showFinder = new Tv\TVSearch($showSearcher, $downloadSearchClients);

$showFinder->run();