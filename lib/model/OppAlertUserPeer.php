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
  
  public static function retrieveByPKAndTypeFilters($user_id, $term_id, $type_filters, $con = null)
  {
    if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		
    $c = new Criteria();
    $c->add(self::USER_ID, $user_id);
    $c->add(self::TERM_ID, $term_id);
    $c->add(self::TYPE_FILTERS, $type_filters);
    $v = self::doSelect($c, $con);

		return !empty($v) ? $v[0] : null;
		
    
  }
  
  public static function getAlert($term, $user, $type_filters)
  {
    $term_obj = OppAlertTermPeer::retrieveByTerm($term);
    if (!$term_obj)
      return null;

    $alert = self::retrieveByPKAndTypeFilters($user->getId(), $term_obj->getId(), $type_filters);
    return $alert;
  }
  
  public static function hasAlert($term, $user, $type_filter)
  {
    $alert = self::getAlert($term, $user, $type_filter);
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
  public static function addAlert($term, $user, $type_filters)
  {
    $term_obj = OppAlertTermPeer::fetchOrInsert($term);

    // fetch object with user_id, term_id, or create a new one
    $alert = self::retrieveByPK($user->getId(), $term_obj->getId());
    if (is_null($alert))
    {
      $alert = new OppAlertUser();
      $alert->setOppAlertTerm($term_obj);
      $alert->setOppUser($user);
    }
    
    // set type filters anew
    $alert->setTypeFilters($type_filters);
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
