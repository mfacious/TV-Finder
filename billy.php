<?php

class getTV {

    private $_shows = array(
        'house',
        'Touch',
        'The Voice UK',
        'tbbt'
    );
    private $_feedUrl = "http://hdbits.org/rss.php?feed=dl&cats[]=2c1c1&cats[]=2c1c4&cats[]=2c1c3&cats[]=2c1c2&passkey=c77c5c462711b90c0f5013a780198a18";
    private $_downloadDir = "/home/tom/Videos";

    public function showMatch($string) {

        foreach ($this->_shows as $show) {
            $bits = explode(" ", $show);
            $regex = "/" . implode('.*', $bits) . ".*S([0-9]{1,2}).*E([0-9]{1,2})/i";
            echo "Regex: {$regex}\n";
            if (preg_match($regex, $string, $matches) > 0) {
                return array('s' => $matches[1], 'e' => $matches[2]);
            }
        }
        return false;
    }

    public function getLocalEps($string) {
        $bits = explode(" ", $string);
        $regex = "/" . implode('.*', $bits) . ".*S([0-9]{1,2}).*E([0-9]{1,2})/i";
        $eps = array();
        $ite = new RecursiveDirectoryIterator($this->_downloadDir);
        foreach (new RecursiveIteratorIterator($ite) as $filename => $cur) {
            if(preg_match($regex,$filename,$matches) > 0){
                $eps[$matches[1]][$matches[2]] = true;
            }
        }
        
        return count($eps) > 0 ? $eps : false;
    }

    public function getRss() {
        $raw = file_get_contents($this->_feedUrl);
        $xml = new SimpleXmlElement($raw);
        return $xml;
    }

    public function checkShows() {
        $xml = $this->getRss();
        foreach ($xml->channel->item as $show) {
            echo "checking string:{$show->title}\n";
            if ($result = $this->showMatch($show->title)) {
                echo "Found\n";
            } else {
                echo "Not found\n";
            }
        }
    }

}

$tv = new getTV();
var_dump($tv->getLocalEps("The Voice UK"));