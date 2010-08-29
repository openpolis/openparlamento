<?php
/*
 * This file is part of the deppPropelActAsPrioritisableBehavior package.
 *
 * (c) 2010 Guglielmo Celata <guglielmo.celata@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
?>
<?php
/**
 * Symfony Propel Prioritising behavior plugin toolkit 
 * 
 * @package plugins
 * @subpackage prioritising
 * @author Guglielmo Celata
 */
class deppPropelActAsPrioritisableBehaviorToolkit 
{

  /**
   * Returns true if the passed model name is prioritisable
   * 
   * @param      string  $object_name
   * @return     boolean
   */
  public static function isPrioritisable($model)
  {
    if (is_object($model))
    {
      $model = get_class($model);
    }

    if (!is_string($model))
    {
      throw new Exception('The param passed to the metod isPrioritisable must be a string.');
    }

    if (!class_exists($model))
    {
      throw new Exception(sprintf('Unknown class %s', $model));
    }

    $base_class = sprintf('Base%s', $model);
    return !is_null(sfMixer::getCallable($base_class.':setPriorityValue'));
  }

  /**
   * Retrieve a prioritisable object
   * 
   * @param  string  $object_model
   * @param  int     $object_id
   */
  public static function retrievePrioritisableObject($object_model, $object_id)
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

      if (!self::isPrioritisable($object))
      {
        throw new Exception(sprintf('Class %s does not have the prioritisable behavior', $object_model));
      }

      return $object;
    }
    catch (Exception $e)
    {
      return sfContext::getInstance()->getLogger()->log($e->getMessage());
    }
  }
}