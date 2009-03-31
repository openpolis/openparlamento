<?php
/*
 * This file is part of the deppPropelActAsLaunchableBehavior package.
 *
 * (c) 2008 Guglielmo Celata <guglielmo.celata@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
?>
<?php
/**
 * Symfony Propel Launching behavior plugin toolkit 
 * 
 * @package plugins
 * @subpackage launching
 * @author Guglielmo Celata
 */
class deppPropelActAsLaunchableToolkit 
{

  /**
   * Retrieve a launchable object (from the model as a string and the id)
   * 
   * @param  string  $object_model
   * @param  int     $object_id
   */
  public static function retrieveLaunchableObject($object_model, $object_id)
  {
    try
    {
      $peer = sprintf('%sPeer', $object_model);

      if (!class_exists($peer))
      {
        throw new deppPropelActAsLaunchableException(sprintf('Unable to load class %s', $peer));
      }

      $object = call_user_func(array($peer, 'retrieveByPk'), $object_id);

      if (is_null($object))
      {
        throw new deppPropelActAsLaunchableException(sprintf('Unable to retrieve %s with primary key %s', $object_model, $object_id));
      }

      return $object;
    }
    catch (Exception $e)
    {
      return sfContext::getInstance()->getLogger()->log($e->getMessage());
    }
  }
  
  public static function swapPriorities($l1, $l2)
  {
    $l1_priority = $l1->getPriority();
    $l2_priority = $l2->getPriority();

    $l1->setPriority(99999); $l1->save();
    $l2->setPriority($l1_priority); $l2->save();
    $l1->setPriority($l2_priority); $l1->save();
  }
  

}
