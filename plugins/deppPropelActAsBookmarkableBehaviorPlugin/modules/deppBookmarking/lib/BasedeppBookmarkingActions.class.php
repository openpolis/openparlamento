<?php
/**
 * deppPropelActAsBookmarkableBehaviorPlugin base actions.
 * 
 * @package    plugins
 * @subpackage bookmarking 
 */
class BasedeppBookmarkingActions extends sfActions
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
      'already_bookmarked'    => __('You have already bookmarked'),
      'missing_params'   => __('Parameters are missing to retrieve ratable object'),
      'post_only'        => __('POST requests only'),
      'bookmarkable_error'    => __('Unable to retrieve bookmarkable object: %s'),
      'anonymous_not_allowed' => __('Anonymous bookmarking is not allowed'),
      'thank_you'        => __('Thank you for your bookmark'),
      'thank_unbookmark'     => __('Thank you'),
      'thank_you_update' => __('Thanks for updating your bookmark'),
      'user_error'       => __('A problem has occured, sorry for the inconvenience'),
    );
  }

  /**
   * <p>Revoke a bookmark from an object. This action is typically executed from an AJAX 
   * request.</p>
   * 
   * @see  deppPropelActAsBookmarkableBehavior API
   */
  public function executeUnbookmark()
  {
    if ($this->getRequest()->getMethod() !== sfRequest::POST)
    {
      return $this->renderText($this->messages['post_only']);
    }

    // Retrieve parameters from request
    $token  = $this->getRequestParameter('token');
    $this->domid  = $this->getRequestParameter('domid');
    
    // Retrieve ratable propel object
    if (is_null($token))
    {
      return $this->renderFatalError($this->messages['missing_params']);
    }

    $object = deppPropelActAsBookmarkableBehaviorToolkit::retrieveFromToken($token);
    
    if (is_null($object))
    {
      return $this->renderFatalError($this->message['bookmarkable_error']);
    }

    $user_id = deppPropelActAsBookmarkableBehaviorToolkit::getUserId();
    if ((is_null($user_id) || $user_id == '') && !$object->allowsAnonymousBookmarking())
    {
      return $this->renderFatalError($this->message['anonymous_not_allowed']);      
    }
    
    $object->clearUserBookmarking($user_id);
    $this->message = $this->messages['thank_unbookmark'];              
    $this->object = $object;
  }
  
  /**
   * <p>Bookmark a propel object. This action is typically executed from an AJAX 
   * request.</p>
   * 
   * @see  deppPropelActAsBookmarkableBehavior API
   */
  public function executeBookmark()
  {

    
    try
    {
      if ($this->getRequest()->getMethod() !== sfRequest::POST)
      {
        return $this->renderText($this->messages['post_only']);
      }
      
      // Retrieve parameters from request
      $token  = $this->getRequestParameter('token');
      $bookmarking = $this->getRequestParameter('bookmarking');
      $this->domid  = $this->getRequestParameter('domid');

      
      // Retrieve ratable propel object
      if (is_null($token) or is_null($bookmarking))
      {
        return $this->renderFatalError($this->messages['missing_params']);
      }
      
      $object = deppPropelActAsBookmarkableBehaviorToolkit::retrieveFromToken($token);
      
      if (is_null($object))
      {
        return $this->renderFatalError($this->message['bookmarkable_error']);
      }
      
      // User retrieval
      $user_id = deppPropelActAsBookmarkableBehaviorToolkit::getUserId();
      if (is_null($user_id) || $user_id == '')
      {
        if (!$object->allowsAnonymousBookmarking())
        {
          $msg = $this->messages['anonymous_not_allowed'];
          sfLogger::getInstance()->warning($msg);
          return $this->renderText($msg);
        }
        else
        {
          // anonymous bookmarks are allowed and are cookie based
          $cookie_name = sprintf('%s_%s', sfConfig::get('app_bookmarking_cookie_prefix', 'bookmarking'), $token);
          if (!is_null($this->getRequest()->getCookie($cookie_name)))
          {
            $message = $this->messages['already_bookmarked'];
          }
          else
          {
            if (!$object->allowsNeutralPosition() && $bookmarking == 0)
            {
              $msg = $this->messages['neutral_not_allowed'];
              sfLogger::getInstance()->warning($msg);
              return $this->renderText($msg);
            }
            else 
            {
              $object->setBookmarking((int) $bookmarking);
              $cookie_ttl = sfConfig::get('app_bookmarking_cookie_ttl', (86400*365*10));
              $cookie_expires = date('Y-m-d H:m:i', time() + $cookie_ttl);
              $this->getResponse()->setCookie($cookie_name, (int)$bookmarking, $cookie_expires);
              $message = $this->messages['thank_you'];              
            }
          }          
        }
      }
      else
      {
        $already_bookmarked = $object->hasBeenBokmarkedByUser($user_id);
        if ($already_bookmarked)
        {
          $message = $this->messages['already_bookmarked'];
        }
        else
        {
          if (!$object->allowsNeutralPosition() && $bookmarking == 0)
          {
            $msg = $this->messages['neutral_not_allowed'];
            sfLogger::getInstance()->warning($msg);
            return $this->renderText($msg);
          }
          else
          {
            $object->setBookmarking((int) $bookmarking, $user_id);
            $message = $this->messages['thank_you'];          
          }          
        }
      }
      
      $this->object = $object;
      $this->bookmarking = $object->getBookmarking();
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
      sfLogger::getInstance()->warning('Bookmarking error: '.$log_info);
    }
    return $this->renderText($this->messages['user_error']);
  }
  
}
