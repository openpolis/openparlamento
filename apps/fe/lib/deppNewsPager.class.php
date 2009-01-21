<?php
class deppNewsPager extends sfPropelPager
{
  public function getGroupedResults()
  {
    $c = $this->getCriteria();
    $results =  call_user_func(array($this->getClassPeer(), $this->getPeerMethod()), $c);
    
    $grouped_results = array();
    foreach ($results as $res)
    {
      $date = strtotime($res->getDate());
      if (!array_key_exists($date, $grouped_results))
      {
        $grouped_results[$date] = array();
      }
      $grouped_results[$date] []= $res;
    }
    krsort($grouped_results);
    return $grouped_results;
  }
}
?>
