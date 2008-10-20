<?php
/**
 * Symfony Propel rating behavior plugin toolkit 
 * 
 * @package plugins
 * @subpackage rating
 * @author Nicolas Perriault
 */
class sfPropelActAsRatableBehaviorToolkit 
{

  /**
   * Retrieves the id of currently connected user, with sfGuardPlugin detection
   * 
   * @return mixed (int or null if no user id retrieved)
   */
  public static function getUserId()
  {
    $session = @sfContext::getInstance()->getUser();

    // if a custom user getId method was defined, use it
    if (is_callable(get_class($session), 'getId'))
    {
      return call_user_func(array($session, 'getId'));
    }
    
    // sfGuardPlugin detection and guard user id retrieval
    if (class_exists('sfGuardSecurityUser')
        && $session instanceof sfGuardSecurityUser
        && is_callable(array($session, 'getGuardUser')))
    {
      $guard_user = $session->getGuardUser();
      if (!is_null($guard_user))
      {
        $guard_user_id = $guard_user->getId();
        if (!is_null($guard_user_id))
        {
          return $guard_user_id;
        }
      }       
    }
    
    $getter = sfConfig::get('app_rating_user_id_getter');
    if (is_array($getter) && class_exists($getter[0]))
    {
      return call_user_func($getter);
    }
    elseif (is_string($getter) && function_exists($getter))
    {
      return $getter();
    }
    else
    {
      return null;
    }
  }
  
  /**
   * Add a token to available ones in the user session and return generated 
   * token
   * 
   * @author Nicolas Perriault
   * @param  string  $object_model
   * @param  int     $object_id
   * @return string
   */
  public static function addTokenToSession($object_model, $object_id)
  {
    $session = sfContext::getInstance()->getUser();
    $token = self::generateToken($object_model, $object_id);
    $tokens = $session->getAttribute('tokens', array(), 'sf_ratables');
    $tokens = array($token => array($object_model, $object_id)) + $tokens;
    $tokens = array_slice($tokens, 0, sfConfig::get('app_rating_max_tokens', 10));
    $session->setAttribute('tokens', $tokens, 'sf_ratables');
    return $token;
  }
  
  /**
   * Generates token representing a ratable object from its model and its id
   * 
   * @author Nicolas Perriault
   * @param  string  $object_model
   * @param  int     $object_id
   * @return string
   */
  public static function generateToken($object_model, $object_id)
  {
    return md5(sprintf('%s-%s-%s', $object_model, $object_id, sfConfig::get('app_rating_salt', 'r4t4bl3')));
  }
  
  /**
   * Returns true if the passed model name is ratable
   * 
   * @author     Xavier Lacot
   * @param      string  $object_name
   * @return     boolean
   */
  public static function isRatable($model)
  {
    if (is_object($model))
    {
      $model = get_class($model);
    }

    if (!is_string($model))
    {
      throw new Exception('The param passed to the metod isRatable must be a string.');
    }

    if (!class_exists($model))
    {
      throw new Exception(sprintf('Unknown class %s', $model));
    }

    $base_class = sprintf('Base%s', $model);
    return !is_null(sfMixer::getCallable($base_class.':setRating'));
  }

  /**
   * Retrieve a ratable object
   * 
   * @param  string  $object_model
   * @param  int     $object_id
   */
  public static function retrieveRatableObject($object_model, $object_id)
  {
    try
    {
      $peer = sprintf('%sPeer', $object_model);

      if (!class_exists($peer))
      {
        throw new Exception(sprintf('Unable to load class %s', $peer));
      }

      $object = call_user_func(array($peer, 'retrieveByPk'), $object_id);

      if (is_null($object))
      {
        throw new Exception(sprintf('Unable to retrieve %s with primary key %s', $object_model, $object_id));
      }

      if (!sfPropelActAsRatableBehaviorToolkit::isRatable($object))
      {
        throw new Exception(sprintf('Class %s does not have the ratable behavior', $object_model));
      }

      return $object;
    }
    catch (Exception $e)
    {
      return sfContext::getInstance()->getLogger()->log($e->getMessage());
    }
  }
  
  /**
   * Retrieve ratable object instance from token
   * 
   * @author Nicolas Perriault
   * @param  string  $token
   * @return BaseObject
   */
  public static function retrieveFromToken($token)
  {
    $session = sfContext::getInstance()->getUser();
    $tokens = $session->getAttribute('tokens', array(), 'sf_ratables');
    if (array_key_exists($token, $tokens) && is_array($tokens[$token]) && class_exists($tokens[$token][0]))
    {
      $object_model = $tokens[$token][0];
      $object_id    = $tokens[$token][1];
      return self::retrieveRatableObject($object_model, $object_id);
    } else return null;
  }

}
