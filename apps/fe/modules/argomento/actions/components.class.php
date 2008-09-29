<?php

class argomentoComponents extends sfComponents
{
  public function executeElencoDdl()
  {
    $this->atti = OppTeseoPeer::doSelectAtto($this->teseo_id);
  }

}

?>	