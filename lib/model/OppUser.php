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
  public function isAdhoc()
  {
    return $this->getIsAdhoc();
  }

  public function isPremium()
  {
    return $this->getIsPremium();
  }
  
  public function isActive()
  {
    return $this->getIsActive();
  }
  
  public function getToken()
  {
    $apikey = sfConfig::get('api_opaccesso_key', 'XXXX');
    
    $user_id = $this->getId();
    
    // lettura del token in remoto (su accesso)
    $remote_guard_host = sfConfig::get('sf_remote_guard_host', 'op_accesso.openpolis.it');
    $xml = simplexml_load_file("http://$remote_guard_host/index.php/api/getUserToken/apikey/$apikey/user_id/$user_id");

    // l'API di op_guard torna un oggetto error e quindi il corrispettivo oggetto user è vuoto
    // con simplexml, quando il nodo esiste è un array diverso da zero
    if (count($xml->user) > 0)
    {
 	    return $xml->user->token;
    } elseif (count($xml->error) > 0) {
      throw new Exception($xml->error);
    } 
  }
  
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

  /**
   * check if the user is indirectly monitoring the act
   * indirect monitoring means the user is monitoring a tag associated to the act
   *
   * @return void
   * @author Guglielmo Celata
   **/
  public function isIndirectlyMonitoringAct($act_id)
  {
    $user_monitored_tags_pks = $this->getMonitoredPks('Tag');
    $c = new Criteria();
    $c->addJoin(OppAttoPeer::ID, TaggingPeer::TAGGABLE_ID);
    $c->add(TaggingPeer::TAG_ID, $user_monitored_tags_pks, Criteria::IN);
    $c->add(OppAttoPeer::ID, $act_id);
    $count = OppAttoPeer::doCount($c);
    return ($count>0?true:false);
  }
  
}

sfPropelBehavior::add(
  'OppUser', 
  array('deppPropelActAsMonitorerBehavior' =>
        array('count_monitored_objects_field' => 'NMonitoredObjects', // refers to UserPeer::N_MONITORED_OBJECTS
              )));

