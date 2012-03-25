<?php

define('DOWNLOAD_DIR', '/home/tom/Videos');


require('library/autoloader.php');

$showSearcher = new Tv\Searchers\FileSearcher(DOWNLOAD_DIR);

$showFinder = new Tv\TVSearch($showSearcher);

$showFinder->run();