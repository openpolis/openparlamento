<?php
/*
 * This file is part of the openparlamento project
 * (c) 2009 Guglielmo Celata <g.celata@depp.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
* This class contains mostly static methods related to the alerting functionalities
*
* @author     Guglielmo Celata <g.celata@depp.it>
* @package    alerting
*/
class oppAlertingTools
{

  /**
   * fetch and return user alerts data structure
   *
   * @param string $user 
   * @param string $max_results
   * @return array of hashes ('term' => $term, 'results' => $results)
   * @author Guglielmo Celata
   */
  public static function getUserAlerts($user, $max_results = 10)
  {
    // arguments validation
    if (!$user instanceof OppUser)
      throw new Exception("first argument must be of type user");

    // loop to build static data-structure (self::$user_alerts)
    $user_alerts = array();
    $alert = OppAlertUserPeer::fetchUserAlerts($user);
    foreach ($alert as $alert)
    {
      $alert_term = $alert->getOppAlertTerm()->getTerm();
      if ($user->getLastAlertedAt())
      {
        $time_constraints = array(
          'created_at_dt' => sprintf("[%s TO NOW]", $user->getLastAlertedAt("%Y-%m-%dT%H:%M:%SZ"))
        );
      } else {
        $time_constraints = array(
          'created_at_dt' => "[NOW-".sfConfig::get('alert_default_months_back', 9)."MONTHS/SECOND TO NOW]"
        );
      }
      $alert_results = deppOppSolr::getSfResults($alert_term, 0, $max_results, $time_constraints, true);
      $user_alert = array(
        'term' => $alert_term,
        'results' => $alert_results
      );
      $user_alerts []= $user_alert;
    } 
    return $user_alerts; 
  } 
  
  /**
   * counts the total number of notifications for the given alerts array
   *
   * @param string $user_alerts 
   * @return void
   * @author Guglielmo Celata
   */
  public function countTotalAlertsNotifications($user_alerts)
  {
    $total = 0;
    foreach ($user_alerts as $alert) {
      $total += count($alert['results']);
    }
    return $total;
  } 
 
}