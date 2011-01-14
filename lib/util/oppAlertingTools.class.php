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
   * @param string $force_last_alert - date to test as if it was last alerted on...
   * @return array of hashes ('term' => $term, 'results' => $results)
   * @author Guglielmo Celata
   */
  public static function getUserAlerts($user, $max_results = 10, $last_alert = null)
  {
    // arguments validation
    if (!$user instanceof OppUser)
      throw new Exception("first argument must be of type user");

    // if last alert is not passed, then fetch it, as not to break compatibility
    if (is_null($last_alert))
      $last_alert = $user->getLastAlertedAt("%Y-%m-%dT%H:%M:%SZ");

    // loop to build static data-structure (self::$user_alerts)
    $user_alerts = array();
    $alert = OppAlertUserPeer::fetchUserAlerts($user);
    foreach ($alert as $alert)
    {
      $alert_term = $alert->getOppAlertTerm()->getTerm();
      if ($last_alert)
      {
        $fields_constraints = 'created_at_dt:' . sprintf("[%s TO NOW]", $last_alert);
      } else {
        $fields_constraints = 'created_at_dt:' . sprintf("[NOW-%dDAYS/SECOND TO NOW]", sfConfig::get('app_alert_default_days_back', 9));
      }

      $type_filters_s = OppAlertTermPeer::get_filters_labels($alert->getTypeFilters());
      if (!is_null($type_filters_s) && $type_filters_s != '') {
        $type_filters = explode("|", $alert->getTypeFilters());
      } else {
        $type_filters = array();
      }
      
      if (count($type_filters)) {
        $type_constraints = "";
        foreach ($type_filters as $cnt => $type_filter) {
          $type_constraint = "";
          switch ($type_filter) {
            case 'politici':
              $type_constraint ="(+sfl_model:OppPolitico)";
              break;
            case 'argomenti':
              $type_constraint = "(+sfl_model:Tag)";
              break;
            case 'emendamenti':
              $type_constraint = "(+sfl_model:OppEmendamento)";
              break;
            case 'votazioni':
              $type_constraint = "(+sfl_model:OppVotazione)";
              break;
            case 'resoconti':
              $type_constraint = "(+sfl_model:OppResoconto)";
              break;
            case 'disegni':
            case 'decreti':
            case 'decrleg':
            case 'mozioni':
            case 'interpellanze':
            case 'interrogazioni':
            case 'risoluzioni':
            case 'odg':
            case 'comunicazionigoverno':
            case 'audizioni':
              $type_constraint = "(+sfl_model:(OppAtto OppDocumento) +tipo_atto_s:$type_filter)";
              break;          
          }
          $type_constraints .= ($cnt > 0?' OR ':'') . $type_constraint;
        }
        if ($type_constraints != "") {
          $fields_constraints .= ($fields_constraints != ''?" AND ($type_constraints)":$type_constraints);
        }
      }
      
      $alert_results = deppOppSolr::getSfResults($alert_term, 0, $max_results, $fields_constraints, true);
      $user_alert = array(
        'term' => $alert_term,
        'type_filters' => $type_filters_s,
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