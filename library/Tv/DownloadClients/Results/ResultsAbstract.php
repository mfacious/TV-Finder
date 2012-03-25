<?php

namespace Tv\DownloadClients\Results;

abstract class ResultsAbstract implements ResultsInterface
{
    protected $_downloadUrl;
    
    public function getDownloadUrl()
    {
        return $this->_downloadUrl;
    }
    
    public function setDownloadUrl($url)
    {
        if(!is_string($url))
        {
            throw new \InvalidArgumentException(__METHOD__ . ' requires that'
                    . ' you pass a string url for the download url');
        }
        
        if(empty($url))
        {
            throw new \InvalidArgumentException(__METHOD__ . ' requires you'
                    . ' pass a non-empty url as an arg.');
        }
        
        $this->_downloadUrl = $url;
        
        return $this;
    }
}