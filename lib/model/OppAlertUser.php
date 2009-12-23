<?php

/**
 * Subclass for representing a row from the 'opp_alert_user' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppAlertUser extends BaseOppAlertUser
{
  
  public function save($con = null)
  {
    parent::save($con);

    $term = $this->getOppAlertTerm($con);
    $term->setNAlerts($this->_countNAlertsForTerm($con));
    $term->save($con);
    
    $user = $this->getOppUser($con);
    $user->setNAlerts($this->_countNAlertsForUser($con));
    $user->save($con);
  }
  
  public function delete($con = null)
  {
    $term = $this->getOppAlertTerm($con);
    $user = $this->getOppUser($con);
    $n_alerts_term = $this->_countNAlertsForTerm($con);
    $n_alerts_user = $this->_countNAlertsForUser($con);

    parent::delete($con);
    
    $term->setNAlerts($n_alerts_term - 1);
    $term->save($con);
    $user->setNAlerts($n_alerts_user - 1);
    $user->save($con);
  }

  private function _countNAlertsForTerm($con = null)
  {
    $c = new Criteria($con);
    $c->add(OppAlertUserPeer::TERM_ID, $this->getTermId());
    return OppAlertUserPeer::doCount($c);
  }

  private function _countNAlertsForUser($con = null)
  {
    $c = new Criteria($con);
    $c->add(OppAlertUserPeer::USER_ID, $this->getUserId());
    return OppAlertUserPeer::doCount($c);
  }
  
}
