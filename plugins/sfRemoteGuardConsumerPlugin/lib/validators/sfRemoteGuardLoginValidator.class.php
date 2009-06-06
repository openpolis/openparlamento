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
	   
     // controllo validità utente e password in remoto
     $remote_guard_host = sfConfig::get('sf_remote_guard_host', 'op_accesso.openpolis.it' ); 
     $xml = simplexml_load_file("http://$remote_guard_host/index.php/getUser/$username/$password/$remember");

     // l'API di op_guard torna un oggetto error e quindi il corrispettivo oggetto user è vuoto
     // con simplexml, quando il nodo esiste è un array diverso da zero
     if (count($xml->user) > 0)
     {
  	   $this->getContext()->getUser()->signIn($xml->user, $remember);
       return true;       
     }

     $error = $this->getParameter('login_error');
     return false;
  }
}
?>
