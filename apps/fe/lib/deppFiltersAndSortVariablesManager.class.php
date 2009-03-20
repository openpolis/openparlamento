<?php
/**
 * deppFiltersAndSortVariablesManager provides static methods for 
 * managing session variables related to filters and sort criteria
 *
 *
 * @package    op_openparlamento
 * @subpackage fe
 * @author     Guglielmo Celata <guglielmo.celata@gmail.com>
 */
class deppFiltersAndSortVariablesManager
{

  /**
   * keeps track of modules or actions last visited
   * reset filters and sort session variables when
   * the action or module changes
   *
   * @param  sfSession
   * @param  string - type [Module|Action]
   * @param  array  - namespaces to remove
   * @return void
   * @author Guglielmo Celata
   */
  public static function resetVars($session, $type, $stored_name, $namespaces = array())
  {
    
    if ($type == 'module' || $type == 'Module' || $type == 'm' || $type == 'M')
      $actual_name = sfContext::getInstance()->getModuleName();
    elseif ($type == 'action' || $type == 'Action' || $type == 'a' || $type == 'A')
      $actual_name = sfContext::getInstance()->getActionName();
    else
      return;
    
    $stored_act_mod = $session->getAttribute($stored_name, 'none');
    sfLogger::getInstance()->info("xxx: actual_name:$actual_name:");
    sfLogger::getInstance()->info("xxx: stored_act_mod:$stored_act_mod:");
    if ($actual_name != $stored_act_mod)
    {
      sfLogger::getInstance()->info('xxx: will reset filters');
      foreach ($namespaces as $ns)
        $session->getAttributeHolder()->removeNamespace($ns);
      $session->setAttribute($stored_name, $actual_name);
    }
  }
  
  public static function arrayHasNonzeroValue($ar)
  {
    foreach ($ar as $i)
    {
      if ($i != '0' || (is_int($i) && $i != 0)) return 1;
    }

    return 0;
  }
  
}
