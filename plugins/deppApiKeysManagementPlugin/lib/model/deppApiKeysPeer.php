<?php

  // include base peer class
  require_once 'plugins/deppApiKeysManagementPlugin/lib/model/om/BasedeppApiKeysPeer.php';

  // include object class
  include_once 'plugins/deppApiKeysManagementPlugin/lib/model/deppApiKeys.php';


/**
 * Skeleton subclass for performing query and update operations on the 'depp_api_keys' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    plugins.deppApiKeysManagementPlugin.lib.model
 */
class deppApiKeysPeer extends BasedeppApiKeysPeer {


  /**
   * controlla se la chiave per le API è valida
   *
   * @param string - il valore della chiave
   * @return boolean
   * @author Guglielmo Celata
   **/
  public static function isValidKey($value)
  {
    $c = new Criteria();
    $c->add(self::VALUE, $value);
    $res = self::doCount($c);
    return $res==1?true:false;
  }
  
  /**
   * controlla se la chiave per le API è quella interna
   *
   * @param string - il valore della chiave
   * @return boolean
   * @author Guglielmo Celata
   **/
  public static function isValidInternalKey($value)
  {
    $c = new Criteria();
    $c->add(self::VALUE, $value);
    $c->add(self::REQ_NAME, 'Interna');
    $res = self::doCount($c);
    return $res==1?true:false;
  }
  

} // deppApiKeysPeer
