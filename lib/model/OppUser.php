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

