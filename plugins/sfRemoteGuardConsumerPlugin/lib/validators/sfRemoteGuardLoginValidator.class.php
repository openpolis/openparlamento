<?php
/*****************************************************************************
 *    Questo file e' parte del progetto openpolis.
 * 
 *    openpolis - la politica trasparente
 *    copyright (C) 2008
 *    Ass. Democrazia Elettronica e Partecipazione Pubblica, 
 *    Via Luigi Montuori 5, 00154 - Roma, Italia
 *
 *    openpolis e' free software; e' possibile redistribuirlo o modificarlo
 *    nei termini della General Public License GNU, versione 2 o successive;
 *    secondo quanto pubblicato dalla Free Software Foundation.
 *
 *    openpolis e' distribuito nella speranza che risulti utile, 
 *    ma SENZA ALCUNA GARANZIA.
 *    
 *    Potete trovare la licenza GPL e altre informazioni su licenze e 
 *    copyright, nella cartella "licenze" del package.
 *
 *    $HeadURL$
 *    $LastChangedDate$
 *    $LastChangedBy$
 *    $LastChangedRevision$
 *
 ****************************************************************************/
?>
<?php

class sfRemoteGuardLoginValidator extends sfValidator
{

  public function initialize($context, $parameters = null)
  {
    // initialize parent
    parent::initialize($context);

    // set defaults
    $this->setParameter('login_error', 'Invalid input');
    $this->getParameterHolder()->add($parameters);

    return true;
  }

  public function execute(&$value, &$error)
  {
    $password_param = $this->getParameter('password_field');
    $remember_param = $this->getParameter('remember_field');
    $password = $this->getContext()->getRequest()->getParameter($password_param);
    $remember = $this->getContext()->getRequest()->getParameter($remember_param);
    $username = $value;
    if (!$remember) $remember = 0;


    // inizio dialogo con op_access per validazione, set della remember key e retrieve xml info complete 

    // controllo validità utente e password in remoto
    $remote_guard_host = sfConfig::get('sf_remote_guard_host', 'op_accesso.openpolis.it' );

    // script can be forced in configuration settings.yml
    $script = sfConfig::get('sf_remote_guard_script', '');
    if ($script == ''){
        $script = str_replace('fe', 'be', sfContext::getInstance()->getRequest()->getScriptName());
        if ($script == '/be.php') $script = '/index.php';
    }

    $apikey = sfConfig::get('sf_internal_api_key', 'xxx');
    $verify_url = sprintf("http://%s%s/verifyUser/%s/%s/%s", 
                          $remote_guard_host, $script, $apikey, $username, $password);
    sfContext::getInstance()->getLogger()->info(sprintf("xxx: verify_url: %s", $verify_url));
    $xml = simplexml_load_file($verify_url);

    if (count($xml->error))
    {
      $error = $this->getParameter('login_error');
      return false;
    }

    if (count($xml->user))
    {
      // rimozione remember keys expired
      $clear_rks_url = sprintf("http://%s%s/clearOldRememberKeys/%s",
                               $remote_guard_host, $script, $apikey);   
      sfContext::getInstance()->getLogger()->info(sprintf("xxx: clear_rks_url: %s", $clear_rks_url));
      $clear_rks_xml = simplexml_load_file($clear_rks_url);
      if (count($clear_rks_xml->error))
      {
        $error = $clear_rks_xml->error;
        return false;         
      }  	   

      if (count($clear_rks_xml->success)) {
        // set nuova remember key per l'utente
        $set_rk_url = sprintf("http://%s%s/setNewUserRememberKey/%s/%s",
                              $remote_guard_host, $script, $apikey, $xml->user->hash);   
        sfContext::getInstance()->getLogger()->info(sprintf("xxx: set_rk_url: %s", $set_rk_url));
        $set_rk_xml = simplexml_load_file($set_rk_url);
        if (count($set_rk_xml->error))
        {
          $error = $set_rk_xml->error;
          return false;         
        }
        
        if (count($set_rk_xml->remember_key)) {
          $rk = $set_rk_xml->remember_key;
          
          // richiesta xml utente completo, partendo dalla rk
          $get_user_url = sprintf("http://%s%s/getUserByRememberKey/%s/%s", 
                                  $remote_guard_host, $script, $apikey, $rk);   
          sfContext::getInstance()->getLogger()->info(sprintf("xxx: get_user_url: %s", $get_user_url));
          $user_xml = simplexml_load_file($get_user_url);
          if (count($user_xml->error))
          {
            $error = $user_xml->error;
            return false;                  
          }

          if (count($user_xml->user)) {
            $this->getContext()->getUser()->signIn($user_xml->user, $remember==1?'remember':'session');
            return true;       
          }
        }
      }
    } 
  
    $error = 'generic connection_error';
    return false;
  }
  
  
  
}
?>
