<?php
/*
 * This file is part of the deppPropelActAsBookmarkableBehavior package.
 *
 * (c) 2008 Guglielmo Celata <guglielmo.celata@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
?>
<?php
/**
 * Symfony Propel Bookmarking behavior plugin toolkit 
 * 
 * @package plugins
 * @subpackage bookmarking
 * @author Guglielmo Celata
 */
class deppPropelActAsBookmarkableToolkit 
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
    
    $getter = sfConfig::get('app_bookmarking_user_id_getter');
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
   * Returns true if the passed model name is bookmarkable
   * 
   * @author     Xavier Lacot
   * @param      string  $object_name
   * @return     boolean
   */
  public static function isBookmarkable($model)
  {
    if (is_object($model))
    {
      $model = get_class($model);
    }

    if (!is_string($model))
    {
      throw new Exception('The param passed to the metod isBookmarkable must be either an object or a string.');
    }

    if (!class_exists($model))
    {
      throw new Exception(sprintf('Unknown class %s', $model));
    }

    $base_class = sprintf('Base%s', $model);
    return !is_null(sfMixer::getCallable($base_class.':getBookmarkableReferenceKey'));
  }

  /**
   * Retrieve a bookmarkable object
   * 
   * @param  string  $object_model
   * @param  int     $object_id
   */
  public static function retrieveBookmarkableObject($object_model, $object_id)
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

      if (!self::isBookmarkable($object))
      {
        throw new Exception(sprintf('Class %s does not have the bookmarkable behavior', $object_model));
      }

      return $object;
    }
    catch (Exception $e)
    {
      return sfContext::getInstance()->getLogger()->log($e->getMessage());
    }
  }
  

}
