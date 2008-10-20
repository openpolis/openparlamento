<?php
/**
 * sfPropelActAsRatableBehaviorPlugin base actions.
 * 
 * @package    plugins
 * @subpackage rating 
 * @author     Nicolas Perriault <nperriault@gmail.com>
 * @link       http://trac.symfony-project.com/trac/wiki/sfPropelActAsRatableBehaviorPlugin
 */
class BasesfRatingActions extends sfActions
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
      'ratable_error'    => __('Unable to retrieve ratable object: %s'),
      'thank_you'        => __('Thank you for your vote'),
      'thank_you_update' => __('Thanks for updating your vote'),
      'user_error'       => __('A problem has occured, sorry for the inconvenience'),
    );
  }
  
  /**
   * <p>Rate a propel object. This action is typically executed from an AJAX 
   * request.</p>
   * 
   * <p>You should override this method in your own exteends actions class if 
   * you need to associate current rating with a user.</p>
   * 
   * @see  sfPropelActAsRatableBehavior API
   * @link http://trac.symfony-project.com/trac/wiki/sfPropelActAsRatableBehaviorPlugin
   */
  public function executeRate()
  {
    try
    {
      if ($this->getRequest()->getMethod() !== sfRequest::POST)
      {
        return $this->renderText($this->messages['post_only']);
      }
      
      // Retrieve parameters from request
      $token  = $this->getRequestParameter('token');
      $rating = $this->getRequestParameter('rating');
      $star_width = $this->getRequestParameter('star_width', sfConfig::get('app_rating_star_width', 25));
      
      // Retrieve ratable propel object
      if (is_null($token) or is_null($rating))
      {
        return $this->renderFatalError($this->messages['missing_params']);
      }
      
      $object = sfPropelActAsRatableBehaviorToolkit::retrieveFromToken($token);
      
      if (is_null($object))
      {
        return $this->renderFatalError($this->message['ratable_error']);
      }
      
      // User retrieval
      $user_id = sfPropelActAsRatableBehaviorToolkit::getUserId();
      if (is_null($user_id) || $user_id == '')
      {
        // Votes are cookie based
        $cookie_name = sprintf('%s_%s', sfConfig::get('app_rating_cookie_prefix', 'rating'), $token);
        if (!is_null($this->getRequest()->getCookie($cookie_name)))
        {
          $message = $this->messages['already_voted'];
        }
        else
        {
          $object->setRating((int) $rating);
          $cookie_ttl = sfConfig::get('app_rating_cookie_ttl', (86400*365*10));
          $cookie_expires = date('Y-m-d H:m:i', time() + $cookie_ttl);
          $this->getResponse()->setCookie($cookie_name, (int)$rating, $cookie_expires);
          $message = $this->messages['thank_you'];
        }
      }
      else
      {
        $already_rated = $object->hasBeenRatedByUser($user_id);
        $object->setRating((int) $rating, $user_id);
        $message = $already_rated === true ?
                         $this->messages['thank_you_update'] :
                         $this->messages['thank_you'];
      }
      
      $this->token = $token;
      $this->rating = $object->getRating();
      $this->star_width = $star_width;
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
      sfLogger::getInstance()->warning('Rating error: '.$log_info);
    }
    return $this->renderText($this->messages['user_error']);
  }
  
}
