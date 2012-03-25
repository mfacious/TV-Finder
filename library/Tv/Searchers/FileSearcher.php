<?php

namespace Tv\Searchers;

class FileSearcher implements SearcherInterface
{
    protected $_downloadDir;
    
    public function getDownloadDir()
    {
        return $this->_downloadDir;
    }

    public function setDownloadDir($downloadDir)
    {
        $this->_downloadDir = $downloadDir;
    }
       
    public function __construct($downloadDir)
    {
        if(empty($downloadDir))
        {
            throw new \InvalidArgumentException(__CLASS__ . ' requires a download'
                    . ' directory to search in as a constructor argument.');
        }
        
        if(!is_string($downloadDir))
        {
            throw new \InvalidArgumentException(__CLASS__ . ' download dir passed'
                    . ' must be a string!');
        }
        
        $this->setDownloadDir($downloadDir);
    }
    
    public function resetSearch()
    {
        return $this;
    }
    
    public function find($name, array $aliases)
    {
        $bits = explode(" ", $name);
        $regex = "/" . implode('.*', $bits) . ".*S([0-9]{1,2}).*E([0-9]{1,2})/i";
        $eps = array();
        $directoryIterator = new \RecursiveDirectoryIterator(
                $this->getDownloadDir()
        );
        
        
        var_dump($name, $aliases, $regex);
        die();
        
        foreach (new RecursiveIteratorIterator($directoryIterator) as $filename => $cur) {
            if(preg_match($regex,$filename,$matches) > 0){
                $eps[$matches[1]][$matches[2]] = true;
            }
        }
    }
    
    
}