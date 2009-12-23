<?php

/**
 * Subclass for performing query and update operations on the 'opp_alert_user' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppAlertUserPeer extends BaseOppAlertUserPeer
{
  
  public static function getAlert($term, $user)
  {
    $term_obj = OppAlertTermPeer::retrieveByTerm($term);
    if (!$term_obj)
      return null;

    $alert = self::retrieveByPK($user->getId(), $term_obj->getId());
    return $alert;
  }
  
  public static function hasAlert($term, $user)
  {
    $alert = self::getAlert($term, $user);
    if ($alert) {
      return true;
    } else {
      return false;
    }
  }
  
  /**
   * given a term (as a string) and a user (as an OppUser object)
   * an alert is created only if it did not exist
   *
   * @param string  $term 
   * @param OppUser $user 
   * @return boolean - true if the alert was created, false otherwise
   * @author Guglielmo Celata
   */
  public static function addAlert($term, $user)
  {
    $term_obj = OppAlertTermPeer::fetchOrInsert($term);

    if (self::retrieveByPK($user->getId(), $term_obj->getId()))
      return false;
      
    $alert = new OppAlertUser();
    $alert->setOppAlertTerm($term_obj);
    $alert->setOppUser($user);
    $alert->save();
    return true;
  }
  
  public static function delAlert($term, $user)
  {

    $alert = self::getAlert($term, $user);
    if (!$alert)
      return false;
      
    $alert->delete();
    return true;
  }
  
  public static function fetchUserAlerts($opp_user)
  {
    $c = new Criteria();
    $c->add(self::USER_ID, $opp_user->getId());
    
    return self::doSelect($c);
  }

  public static function countUserAlerts($opp_user)
  {
    $c = new Criteria();
    $c->add(self::USER_ID, $opp_user->getId());
    
    return self::doCount($c);
  }
}
