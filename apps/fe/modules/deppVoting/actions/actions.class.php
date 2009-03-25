<?php
require_once(dirname(__FILE__).'/../../../../../plugins/deppPropelActAsVotableBehaviorPlugin/modules/deppVoting/lib/BasedeppVotingActions.class.php');
/**
 * deppPropelActAsVotableBehaviorPlugin actions. Feel free to override this class
 * in your dedicated app module.
 * 
 * @package    plugins
 * @subpackage voting 
 * @author     Guglielmo Celata <guglielmo.celata@gmail.com>
 */
class deppVotingActions extends BasedeppVotingActions
{
  
  /**
   * <p>Revoke a vote from an object in an un-ajax way</p>
   * 
   * @see  deppPropelActAsVotableBehavior API
   */
  public function executeUnvoteNoAjax()
  {
    if ($this->getRequest()->getMethod() !== sfRequest::POST)
    {
      $this->setError($this->messages['post_only']);
    }

    // Retrieve parameters from request
    $token  = $this->getRequestParameter('token');
    
    // Retrieve votable propel object
    if (is_null($token))
    {
      $this->setError($this->messages['missing_params']);
    }

    $object = deppPropelActAsVotableBehaviorToolkit::retrieveFromToken($token);
    
    if (is_null($object))
    {
      $this->setError($this->message['votable_error']);
    }

    $user_id = deppPropelActAsVotableBehaviorToolkit::getUserId();
    if ((is_null($user_id) || $user_id == '') && !$object->allowsAnonymousVoting())
    {
      $this->setError($this->message['anonymous_not_allowed']);      
    }
    
    $object->clearUserVoting($user_id);

    $message = $this->messages['thank_unvote'];              
    $this->setFlash('depp_voting_message', $message);
    $this->redirect($this->getRequest()->getReferer());
  }
  
  /**
   * <p>Vote a propel object, un-ajax style</p>
   * 
   * @see  deppPropelActAsVotableBehavior API
   */
  public function executeVoteNoAjax()
  {
    
    try
    {
      if ($this->getRequest()->getMethod() !== sfRequest::POST)
      {
        $this->setError($this->messages['post_only']);
      }
      
      // Retrieve parameters from request
      $token  = $this->getRequestParameter('token');
      $voting = $this->getRequestParameter('voting');
      
      // Retrieve ratable propel object
      if (is_null($token) or is_null($voting))
      {
        $this->setError($this->messages['missing_params']);
      }
      
      $object = deppPropelActAsVotableBehaviorToolkit::retrieveFromToken($token);
      
      if (is_null($object))
      {
        $this->setError($this->message['votable_error']);
      }
      
      // User retrieval
      $user_id = deppPropelActAsVotableBehaviorToolkit::getUserId();
      if (is_null($user_id) || $user_id == '')
      {
        if (!$object->allowsAnonymousVoting())
        {
          $msg = $this->messages['anonymous_not_allowed'];
          sfLogger::getInstance()->warning($msg);
          $this->setError($msg);
        }
        else
        {
          // anonymous votes are allowed and are cookie based
          $cookie_name = sprintf('%s_%s', sfConfig::get('app_voting_cookie_prefix', 'voting'), $token);
          if (!is_null($this->getRequest()->getCookie($cookie_name)))
          {
            $message = $this->messages['already_voted'];
          }
          else
          {
            if (!$object->allowsNeutralPosition() && $voting == 0)
            {
              $msg = $this->messages['neutral_not_allowed'];
              sfLogger::getInstance()->warning($msg);
              $this->setError($msg);
            }
            else 
            {
              $object->setVoting((int) $voting);
              $cookie_ttl = sfConfig::get('app_voting_cookie_ttl', (86400*365*10));
              $cookie_expires = date('Y-m-d H:m:i', time() + $cookie_ttl);
              $this->getResponse()->setCookie($cookie_name, (int)$voting, $cookie_expires);
              $message = $this->messages['thank_you'];              
            }
          }          
        }
      }
      else
      {
        $already_voted = $object->hasBeenVotedByUser($user_id);
        if ($already_voted)
        {
          $message = $this->messages['already_voted'];
        }
        else
        {
          if (!$object->allowsNeutralPosition() && $voting == 0)
          {
            $msg = $this->messages['neutral_not_allowed'];
            sfLogger::getInstance()->warning($msg);
            $this->setError($msg);
          }
          else
          {
            $object->setVoting((int) $voting, $user_id);
            $message = $this->messages['thank_you'];          
          }          
        }
      }

      $this->setFlash('depp_voting_message', $message);
      $this->redirect($this->getRequest()->getReferer());
      
    }
    catch (Exception $e)
    {
      $this->setError($e->getMessage());
    }
  }
  
  protected function setError($err_msg)
  {
    $this->setFlash('depp_voting_message', $err_msg);
    $this->redirect($this->getRequest()->getReferer());
  }
   
}
