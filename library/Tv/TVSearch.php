<?php

namespace Tv;

class TVSearch
{
    
    protected $_searcher;

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
    public function __construct(Searchers\SearcherInterface $searcher)
    {
        $this->setSearcher($searcher);
    }
    
    public function getSearcher()
    {
        return $this->_searcher;
    }

    public function setSearcher(Searchers\SearcherInterface $searcher)
    {
        $this->_searcher = $searcher;
    }

        
    public function getShowList()
    {
        return $this->_showList;
    }

    public function setShowList($showList)
    {
        $this->_showList = $showList;
    }
    
    public function run()
    {
        $shows = $this->getShowList();
        
        $existingEps = $this->getExistingEps($shows);

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
            
            if(!isset($showConfig['name']))
            {
                throw new \InvalidArgumentException(__METHOD__ . 'Show '
                        . 'configuration must contain at least a name!');
            }
            
            $name = $showConfig['name'];
            
            $aliases = array();
            if(isset($showConfig['aliases']))
            {
                $aliases = $showConfig['aliases'];
            }
            
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
}