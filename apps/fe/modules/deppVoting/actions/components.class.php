<?php
require_once(dirname(__FILE__).'/../../../../../plugins/deppPropelActAsVotableBehaviorPlugin/modules/deppVoting/lib/BasedeppVotingComponents.class.php');

class deppVotingComponents extends BasedeppVotingComponents
{
  public function executeVotingBlock()
  {
    
    // embed javascripts for ajax interaction
	  $response = sfContext::getInstance()->getResponse();
    $response->addStylesheet('/deppPropelActAsVotableBehaviorPlugin/css/depp_voting.css');

    $this->must_login = false;

    if (is_null($this->object))
    {
      sfLogger::getInstance()->debug('A NULL object cannot be voted');
      return '';
    }

    $this->user_id = deppPropelActAsVotableBehaviorToolkit::getUserId();
    // anonymous votes
    if ( (is_null($this->user_id) || $this->user_id == '') && !$this->object->allowsAnonymousVoting())
    {
      $this->must_login = true;
    }
    
    $object_class = get_class($this->object);
    $object_id = $this->object->getReferenceKey();
    $this->token = deppPropelActAsVotableBehaviorToolkit::addTokenToSession($object_class, $object_id);

  }

  public function executeVotingBlockSmall()
  {
    
    // embed javascripts for ajax interaction
	  $response = sfContext::getInstance()->getResponse();
    $response->addStylesheet('/deppPropelActAsVotableBehaviorPlugin/css/depp_voting.css');

    $this->must_login = false;

    if (is_null($this->object))
    {
      sfLogger::getInstance()->debug('A NULL object cannot be voted');
      return '';
    }

    $this->user_id = deppPropelActAsVotableBehaviorToolkit::getUserId();
    // anonymous votes
    if ( (is_null($this->user_id) || $this->user_id == '') && !$this->object->allowsAnonymousVoting())
    {
      $this->must_login = true;
    }
    
    $object_class = get_class($this->object);
    $object_id = $this->object->getReferenceKey();
    $this->token = deppPropelActAsVotableBehaviorToolkit::addTokenToSession($object_class, $object_id);

  }
  
  public function executeVotingDetailsSmall()
  {
    $object_class = get_class($this->object);
    $object_id = $this->object->getReferenceKey();
    $this->token = deppPropelActAsVotableBehaviorToolkit::addTokenToSession($object_class, $object_id);
  }


}

?>