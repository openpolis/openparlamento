<?php

/**
 * Subclass for representing a row from the 'opp_user' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppUser extends BaseOppUser
{
  public function __toString()
  {
    if ($this->getPublicName())
    {
      return ucfirst(strtolower($this->getFirstName())).' '.strtoupper($this->getLastName());
    }
    else
    {
      return $this->getNickname();
    }
  }
  
  
}
