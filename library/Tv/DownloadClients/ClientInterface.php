<?php

namespace Tv\DownloadClients;

interface ClientInterface
{
    /**
     * Find method acepts a string name of a file to find on a remote site
     * 
     * It must return a result object that implements the 
     * Clients\Results\ResultInterface. 
     */
    public function find($name);
}