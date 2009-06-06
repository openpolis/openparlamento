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
class sfRemoteGuardSsoFilter extends sfFilter
{
  public function execute ($filterChain)
  {
    //execute the filter only once, if the user is NOT authenticated
    if ($this->isFirstCall() && !$this->getContext()->getUser()->isAuthenticated())
    {
      $key = $this->getContext()->getRequest()->getCookie(sfConfig::get('app_cookies_sso_name', 'opSSO'));
      if ($key)
      {
 	      // controllo esistenza utente con remember_key su server di autenticazione
 	      $remote_guard_host = sfConfig::get('sf_remote_guard_host', 'op_accesso.openpolis.it' ); 
        $xml = simplexml_load_file("http://$remote_guard_host/index.php/getUserByRememberKey/$key");
        if ($xml->user instanceof SimpleXMLElement && $xml->user->asXML() != '')
        {
      	  $this->getContext()->getUser()->signIn($xml->user);        
          
        }
      }
    }
    
  	//execute next filter
  	$filterChain->execute();
  }
}
?>