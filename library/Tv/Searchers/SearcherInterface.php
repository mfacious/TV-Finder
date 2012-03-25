<?php

namespace Tv\Searchers;

interface SearcherInterface
{
    /**
     * ResetSearch should reset the current directory location to the root
     * directory passed to it.
     * 
     * This is to allow new searches to be run. 
     * @return __CLASS__
     */
    public function resetSearch();
    
    /**
     * Find method should return an associative array of shows that we found
     * to match the name or aliases passed. 
     */
    public function find($showName, array $showAliases);
}