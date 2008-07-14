<?php

class customArrayPager extends sfPager
{
  protected $resultsArray = null;
 
  public function __construct($class = null, $maxPerPage = 10, $nbResults)
  {
    parent::__construct($class, $maxPerPage);
	
	$this->total=$nbResults;
  }
 
  public function init()
  {
    $this->setNbResults($this->total);
 
    if (($this->getPage() == 0 || $this->getMaxPerPage() == 0))
    {
     $this->setLastPage(0);
    }
    else
    {
     $this->setLastPage(ceil($this->getNbResults() / $this->getMaxPerPage()));
    }
  }
 
  public function setResultArray($array)
  {
    $this->resultsArray = $array;
  }
 
  public function getResultArray()
  {
    return $this->resultsArray;
  }
 
  public function retrieveObject($offset) {
    return $this->resultsArray[$offset];
  }
 
  public function getResults()
  {
    //return array_slice($this->resultsArray, ($this->getPage() - 1) * $this->getMaxPerPage(), $this->maxPerPage);
    return $this->resultsArray;
  }
 
}

?>