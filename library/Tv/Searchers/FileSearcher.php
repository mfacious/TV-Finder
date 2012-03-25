<?php

namespace Tv\Searchers;

class FileSearcher implements SearcherInterface
{

    /**
     *
     * @var string $downloadDirectory 
     */
    protected $_downloadDir;
    
    /**
     *
     * @var \RecursiveDirectoryIterator $iterator 
     */
    protected $_directoryIterator;

    public function getDownloadDir()
    {
        return $this->_downloadDir;
    }

    public function setDownloadDir($downloadDir)
    {
        $this->_downloadDir = $downloadDir;
    }

    public function getDirectoryIterator()
    {
        if (!$this->_directoryIterator instanceof \RecursiveDirectoryIterator) {
            throw new \DomainException(__METHOD__ . ' could not find an'
                    . ' instance of the RecursiveDirectoryIterator. Perhaps'
                    . ' you haven\'t called the ' . __CLASS__ . '::'
                    . 'setupDirectoryIterator() method?');
        }

        return $this->_directoryIterator;
    }

    public function setDirectoryIterator($directoryIterator)
    {
        $this->_directoryIterator = $directoryIterator;
    }

    public function __construct($downloadDir)
    {
        if (empty($downloadDir)) {
            throw new \InvalidArgumentException(__CLASS__ . ' requires a download'
                    . ' directory to search in as a constructor argument.');
        }

        if (!is_string($downloadDir)) {
            throw new \InvalidArgumentException(__CLASS__ . ' download dir passed'
                    . ' must be a string!');
        }

        $this->setDownloadDir($downloadDir);
    }

    public function resetSearch()
    {
        $this->setupDirectoryIterator();
        return $this;
    }

    protected function setupRegex(array $names)
    {
        $rules = array();
        foreach ($names as $name) {
            $nameParts = explode(" ", $name);
            $regex = "/" . implode('.*', $nameParts) . ".*S([0-9]{1,2}).*E([0-9]{1,2})/i";

            $rules[$name] = $regex;
        }

        if (empty($rules)) {
            throw new \OutOfRangeException(__METHOD__ . ' Could not generate'
                    . ' any patterns to use to find shows!');
        }

        return $rules;
    }

    protected function setupDirectoryIterator()
    {
        $directoryIterator = new \RecursiveDirectoryIterator(
                        $this->getDownloadDir()
        );

        $this->setDirectoryIterator($directoryIterator);
    }

    public function find($name, array $aliases)
    {
        // Generate an array of all our names and alaises we want to match
        // for this show.
        $names = array_merge($aliases, array($name));

        // Get an array of all the regex patterns we will use.
        $showRegexes = $this->setupRegex($names);
        
        // array that will contain all of the matched episodes we already have.
        $episodes = array();
        

        // Cycle through each of those ptterns and try to find shows.
        foreach ($showRegexes as $pattern) {
            
            $directoryIterator = $this->getDirectoryIterator();

            
            foreach (
                new \RecursiveIteratorIterator($directoryIterator) as $path) {
                
                $fileName = $path->getFilename();
                
                if (preg_match($pattern, $fileName, $matches) > 0) {
                    $episodes[] = array(
                        'series' => $matches[1],
                        'episode' => $matches[2],
                    );
                }
            }
        }
        
        return $episodes;

    }

}