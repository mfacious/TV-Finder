<?php

namespace Tv;

class TVSearch
{
    
    protected $_searcher;
    
    /**
     * Clients are the classes that will be used to search external sources
     * to attept to find the latest episodes.
     * 
     * @var array 
     */
    protected $_downloadClients = array();
    
    protected $_episodeClients = array();

    protected $_showList = array(
        array(
            'name' => 'The big bang theory',
            'aliases' => array(
                'tbbt',
            )
        ),
        array(
            'name' => 'House',
            'aliases' => array(
                'House MD'
            )
        ),
        
    );
    
    /**
     *
     * @param SearcherInterface $searcher 
     */
    public function __construct(
            Searchers\SearcherInterface $searcher,
            array $downloadSearchClients,
            array $episodeClients
    )
    {
        $this->setSearcher($searcher);
        
        if(empty($downloadSearchClients))
        {
            throw new \InvalidArgumentException(__METHOD__ . ' requires that'
                    . ' the clients you pass must not be empty.');
        }
        
        $this->setDownloadClients($downloadSearchClients);
        
        $this->setEpisodeClients($episodeClients);
    }
    
    public function getSearcher()
    {
        return $this->_searcher;
    }

    public function setSearcher(Searchers\SearcherInterface $searcher)
    {
        $this->_searcher = $searcher;
    }
    
    public function getEpisodeClients()
    {
        if(empty($this->_episodeClients))
        {
            throw new \InvalidArgumentException(__METHOD__ . ' no clients have'
                    . ' been set yet! Try setting some with ' . __CLASS__
                    . '::setClients()');
        }
        
        return $this->_episodeClients;
    }

    public function setEpisodeClients(array $clients)
    {
        foreach($clients as $client)
        {
            if(!is_object($client))
            {
                throw new \InvalidArgumentException(__METHOD__ . ' all clients'
                        . ' passed must be objects!');
            }
            
            if(!$client instanceof EpisodeClients\EpisodeClientInterface)
            {
                throw new \InvalidArgumentException(__METHOD__ . ' all clients'
                        . ' passed must implement the ClientInterface.');
            }
            
            $this->addEpisodeClient($client);
        }
        
        return $this;
    }
    
    public function addEpisodeClient(EpisodeClients\EpisodeClientInterface $client)
    {
        $this->_episodeClients[] = $client;
        
        return $this;
    }
    
    public function getDownloadClients()
    {
        if(empty($this->_downloadClients))
        {
            throw new \InvalidArgumentException(__METHOD__ . ' no clients have'
                    . ' been set yet! Try setting some with ' . __CLASS__
                    . '::setClients()');
        }
        
        return $this->_downloadClients;
    }

    public function setDownloadClients(array $clients)
    {
        foreach($clients as $client)
        {
            if(!is_object($client))
            {
                throw new \InvalidArgumentException(__METHOD__ . ' all clients'
                        . ' passed must be objects!');
            }
            
            if(!$client instanceof DownloadClients\ClientInterface)
            {
                throw new \InvalidArgumentException(__METHOD__ . ' all clients'
                        . ' passed must implement the ClientInterface.');
            }
            
            $this->addDownloadClient($client);
        }
        
        return $this;
    }
    
    public function addDownloadClient(DownloadClients\ClientInterface $client)
    {
        $this->_downloadClients[] = $client;
        
        return $this;
    }
        
    public function getShowList()
    {
        return $this->_showList;
    }

    public function setShowList($showList)
    {
        $this->_showList = $showList;
    }
    
    public function getShow($showId)
    {
        if(!isset($this->_showList[$showId]))
        {
            throw new \OutOfBoundsException(__METHOD__ . ' could not find show'
                    . ' with the ID of ' . $showId . '.');
        }
        
        return $this->_showList[$showId];
    }
    
    public function getShowName(array $show)
    {
        if(!isset($show['name']))
        {
            throw new \InvalidArgumentException(__METHOD__ . 'Show '
                    . 'configuration must contain at least a name!');
        }

        return $show['name'];
    }
    
    public function getShowAliases(array $show)
    {
        $aliases = array();
        if(isset($show['aliases']))
        {
            $aliases = $show['aliases'];
        }
        
        return $aliases;
    }
    
    public function run()
    {
        $shows = $this->getShowList();
        
        $existingEps = $this->getExistingEps($shows);
        
        $missingEps = $this->getUpcomingEps($existingEps);
        
        $this->searchForEps($missingEps);
        
        var_dump($missingEps);
        die();

    }
    
    public function getExistingEps(array $shows)
    {
        if(empty($shows))
        {
            throw new \InvalidArgumentException(__METHOD__ . ' does not accept'
                    . ' an empty array of shows to search!');
        }
        
        $results = array();
        
        foreach($shows as $internalId => $showConfig)
        {
            $searcher = $this->getSearcher()->resetSearch();
            
            $name = $this->getShowName($showConfig);
            
            $aliases = $this->getShowAliases($showConfig);
            
            try
            {
                $files = $searcher->find($name, $aliases);
            } catch(\Exception $exception)
            {
                throw $exception;
            }
            
            $results[$internalId] = $files;
        }
        
        return $results;
    }
    
    public function getUpcomingEps($episodes)
    {
        
        $results = array();
        foreach($episodes as $interalId => $existingEpisodes)
        {
            $showInfo = $this->getShow($interalId);
            
            $name = $this->getShowName($showInfo);
            $aliases = $this->getShowAliases($showInfo);
            
            $missingEpisodes = array();
            
            foreach($this->getEpisodeClients() as $client)
            {
                $missingEpisodes[] = $client->getMissingEpisodes(
                        $name, $aliases, $existingEpisodes
                );
            }
            
            $results[$interalId] = $missingEpisodes;
            
        }
        
        return $results;
        
    }
    
    public function searchForEps($missingEpisodes)
    {
        $clients = $this->getDownloadClients();
    }
}