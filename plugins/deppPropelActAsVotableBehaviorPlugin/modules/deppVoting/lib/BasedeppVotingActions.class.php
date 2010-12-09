<?php
/**
 * deppPropelActAsVotableBehaviorPlugin base actions.
 * 
 * @package    plugins
 * @subpackage voting 
 */
class BasedeppVotingActions extends sfActions
{
  
  /**
   * Here we will initiate system messages translatable strings
   * 
   */
  public function preExecute()
  {
    parent::preExecute();
    sfLoader::loadHelpers('I18N');
    $this->messages = array(
      'already_voted'    => __('You have already voted'),
      'missing_params'   => __('Parameters are missing to retrieve ratable object'),
      'post_only'        => __('POST requests only'),
      'votable_error'    => __('Unable to retrieve votable object: %s'),
      'anonymous_not_allowed' => __('Anonymous voting is not allowed'),
      'thank_you'        => __('Thank you for your vote'),
      'thank_unvote'     => __('Thank you'),
      'thank_you_update' => __('Thanks for updating your vote'),
      'user_error'       => __('A problem has occured, sorry for the inconvenience'),
    );
  }


  /**
   * <p>Revoke a vote from an object. This action is typically executed from an AJAX 
   * request.</p>
   * 
   * @see  deppPropelActAsVotableBehavior API
   */
  public function executeUnvote()
  {
    // Retrieve parameters from request
    $token  = $this->getRequestParameter('token');
    $this->domid  = $this->getRequestParameter('domid');
    
    // Retrieve ratable propel object
    if (is_null($token))
    {
      return $this->renderFatalError($this->messages['missing_params']);
    }

    $object = deppPropelActAsVotableBehaviorToolkit::retrieveFromToken($token);
    
    if (is_null($object))
    {
      return $this->renderFatalError($this->message['votable_error']);
    }

    $user_id = deppPropelActAsVotableBehaviorToolkit::getUserId();
    if ((is_null($user_id) || $user_id == '') && !$object->allowsAnonymousVoting())
    {
      return $this->renderFatalError($this->message['anonymous_not_allowed']);      
    }
    
    $object->clearUserVoting($user_id);
    $this->message = $this->messages['thank_unvote'];              
    $this->object = $object;
  }
  
  /**
   * <p>Vote a propel object. This action is typically executed from an AJAX 
   * request.</p>
   * 
   * @see  deppPropelActAsVotableBehavior API
   */
  public function executeVote()
  {
    
    try
    {
      // Retrieve parameters from request
      $token  = $this->getRequestParameter('token');
      $voting = $this->getRequestParameter('voting');
      $this->domid  = $this->getRequestParameter('domid');

      
      // Retrieve ratable propel object
      if (is_null($token) or is_null($voting))
      {
        return $this->renderFatalError($this->messages['missing_params']);
      }
      
      $object = deppPropelActAsVotableBehaviorToolkit::retrieveFromToken($token);
      
      if (is_null($object))
      {
        return $this->renderFatalError($this->message['votable_error']);
      }
      
      // User retrieval
      $user_id = deppPropelActAsVotableBehaviorToolkit::getUserId();
      if (is_null($user_id) || $user_id == '')
      {
        if (!$object->allowsAnonymousVoting())
        {
          $msg = $this->messages['anonymous_not_allowed'];
          sfLogger::getInstance()->warning($msg);
          return $this->renderText($msg);
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
              return $this->renderText($msg);
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
            return $this->renderText($msg);
          }
          else
          {
            $object->setVoting((int) $voting, $user_id);
            $message = $this->messages['thank_you'];          
          }          
        }
      }
      
      $this->object = $object;
      $this->voting = $object->getVoting();
      $this->message = $message;
    }
    catch (Exception $e)
    {
      return $this->renderFatalError($e->getMessage());
    }
  }
  


  
  
  /**
   * This methods will returns a basic user error message while logging a 
   * complete one if provided in the debug log file 
   * 
   * @param string  $log_info  Log information message
   */
  protected function renderFatalError($log_info = null)
  {
    if (!is_null($log_info))
    {
      sfLogger::getInstance()->warning('Voting error: '.$log_info);
    }
    return $this->renderText($this->messages['user_error']);
  }
  
}
