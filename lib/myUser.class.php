<?php

class myUser extends sfRemoteGuardSecurityUser
{
  public function getFirstname()
	{
	  return $this->getAttribute('firstname', '', 'subscriber');
	}

  public function getId()
	{
	  return $this->getAttribute('subscriber_id', '', 'subscriber');
	}
	
	
	private function old_signin($user)
  {
    $this->setAttribute('subscriber_id', $user->getId(), 'subscriber');
    $this->setAuthenticated(true);

    $this->addCredential('subscriber');

    $this->setAttribute('name', $user->__toString(), 'subscriber');
    $this->setAttribute('firstname', $user->getFirstName(), 'subscriber');
    
  }
  
  
  public function signIn($xml_user, $remember = false)
	{
	
    // gestisce il caso di login in locale (gli script batch)
    if ($xml_user instanceof OppUser)
    {
      $this->old_signin($xml_user);
      return;
    }
    
    parent::signIn($xml_user, $remember);

  }
  
  
}
