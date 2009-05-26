<?php

class sfRemoteGuardSecurityUser extends sfBasicSecurityUser
{
  
  

  /**
   * uses information in the $xml_user SimpleXML object to give attributes and permissions to the user
   * also sets remember or sso cookie, depending on the value of the $remember parameter
   *
   * @param $xml_user - SimpleXMLObject
   * @param $remember - boolean
   * @return void
   * @author Guglielmo Celata
   **/
	public function signIn($xml_user, $remember = false)
	{

	  // legge i permission dall'xml user
    $permissions = array();
    foreach ($xml_user->permissions->permission as $perm) 
    {
      $permissions[] = (string)$perm;
    }

	  $this->setAttribute('subscriber_id', (string)$xml_user->subscriber_id, 'subscriber');
	  
	  $this->setAuthenticated(true);

		$expiration_age = sfConfig::get('app_cookies_remember_key_expiration_age', 15 * 24 * 3600);  
    $cookie_remember_name = sfConfig::get('app_cookies_remember_name', 'sfRemember');
    $cookie_sso_name = sfConfig::get('app_cookies_sso_name', 'sfSSO');
    $cookie_path = sfConfig::get('app_cookies_path', '/');
    $cookie_domain = sfConfig::get('app_cookies_domain', 'sfDomain.it');
	  
	  // to remember or not to remember?
	  if ($remember)
	  {      
  		//save the key to the remember cookie
  		sfContext::getInstance()->getResponse()->setCookie($cookie_remember_name, 
  		                                                   (string)$xml_user->remember_key, 
  		                                                   time() + $expiration_age,
  		                                                   $cookie_path, $cookie_domain);
	    
	  } else {
	    // save the hash to the sso cookie
  		sfContext::getInstance()->getResponse()->setCookie($cookie_sso_name, 
  		                                                   (string)$xml_user->remember_key, 
  		                                                   0,
  		                                                   $cookie_path, $cookie_domain);	    
	  }
	
	  // default credential for subscribed users
	  $this->addCredential('subscriber');
	
	  // add all credentials from groups and direct permissions
	  foreach ($permissions as $perm) {
	    $this->addCredential((string)$perm);
	  }
	  
	  $this->setAttribute('name', (string)$xml_user->name, 'subscriber');
	  $this->setAttribute('firstname', (string)$xml_user->firstname, 'subscriber');
	  $this->setAttribute('hash', (string)$xml_user->hash, 'subscriber');
	  
	  // read the last_login ts from the xml (it comes from the DB)
	  $this->setAttribute('last_login', (string)$xml_user->last_login, 'subscriber');

    // store the new last_login ts (now) in the DB
    $remote_guard_host = sfConfig::get('app_remote_guard_host', 'guard.openpolis.it' ); 
    $set_last_login_url = "http://$remote_guard_host/index.php/setLastLogin/" . (string)$xml_user->hash . 
                          "/" .  urlencode(date('Y-m-d H:i:s'));
    $xml = simplexml_load_file($set_last_login_url);
    
    // go home if something really wrong happens (could not write last_login to db)
    if (!$xml->ok instanceof SimpleXMLElement)
      sfLogger::getInstance()->info('xxx: last login set failed: ' . (string)$xml->error);
	}
	
	public function __toString()
	{
	  return $this->getAttribute('name', '', 'subscriber');
	}
  
	protected function generateRandomKey($user, $len = 40)
  {
    $string = '';
    $pool   = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    for ($i = 1; $i <= $len; $i++)
    {
      $string .= substr($pool, rand(0, 61), 1);
    }

    return md5($string . $user->__toString());
  }
  

	public function signOut()
	{
	  $this->getAttributeHolder()->removeNamespace('subscriber');
	  $this->getAttributeHolder()->remove('redirect_url');
    
	  $this->setAuthenticated(false);
	  $this->clearCredentials();
	  
		$expiration_age = sfConfig::get('app_cookies_remember_key_expiration_age', 15 * 24 * 3600);  
    $cookie_remember_name = sfConfig::get('app_cookies_remember_name', 'sfRemember');
    $cookie_path = sfConfig::get('app_cookies_path', '/');
    $cookie_domain = sfConfig::get('app_cookies_domain', 'sfDomain.it');
    $cookie_sso_name = sfConfig::get('app_cookies_sso_name', 'sfSSO');
		sfContext::getInstance()->getResponse()->setCookie($cookie_remember_name, '', time() - $expiration_age,
		                                                   $cookie_path, $cookie_domain );
    sfContext::getInstance()->getResponse()->setCookie($cookie_sso_name, '', time() - 1,
                                                       $cookie_path, $cookie_domain );
	}
	
}

?>