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
 * This Propel behavior aims at allowing the user to launch any Propel
 * object in a positive or negative weay
 * 
 *
 * @package    plugins
 * @subpackage launching 
 * @author     Guglielmo Celata <guglielmo.celata@gmail.com>
 * @author     Nicolar Perriault
 * @author     Fabian Lange
 * @author     Vojtech Rysanek
 */
class deppPropelActAsLaunchableBehavior
{

  /**
   * Check if an Object has been launched with any namespace
   *
   * @param  BaseObject  $object
   * @throws deppPropelActAsLaunchableException
   * @return Array of namespaces where the object was launched
   **/
  public function hasBeenLaunched(BaseObject $object)
  {
    $c = new Criteria();
    $c->add(sfLaunchingPeer::OBJECT_ID, $object->getPrimaryKey());
    $c->add(sfLaunchingPeer::OBJECT_MODEL, get_class($object));
    $c->clearSelectColumns();
    $c->addSelectColumn(sfLaunchingPeer::NAMESPACE);
    $rs = sfLaunchingPeer::doSelectRS($c);
    $launches = array();
    while($rs->next())
    {
      $launches []= $rs->getString(1);
    }
    return $launches;
  }
  
  
  
  /**
   * launches the Object
   *
   * @param  BaseObject  $object
   * @param  string      $namespace
   * @throws deppPropelActAsLaunchableException
   * @return the number of affected rows
   **/
  public function setLaunching(BaseObject $object, $namespace = 'home')
  {
    if ($object->isNew())
    {
      throw new deppPropelActAsLaunchableException('Unsaved objects are not launchable');
    }

    if (!is_string($namespace))
      throw new deppPropelActAsLaunchableException('Namespace can only be a string');

    $launch = new sfLaunching();
    $launch->setObjectModel(get_class($object));
    $launch->setObjectId($object->getPrimaryKey());
    $launch->setNamespace($namespace);
    $launch->setPriority(sfLaunchingPeer::getNewLaunchPriority($namespace));
    $ret = $launch->save();

    return $ret;
  }

  /**
   * Remove the launching of an object from a namespace
   *
   * @param BaseObject $object 
   * @param string $namespace 
   * @return void
   * @author Guglielmo Celata
   */
  public function removeLaunching(BaseObject $object, $namespace='home')
  {
    if (!is_string($namespace))
      throw new deppPropelActAsLaunchableException('Namespace can only be a string');

    $l = sfLaunchingPeer::retrieveByModelIdNamespace(get_class($object), $object->getPrimaryKey(), $namespace);
    $l->delete();
    
    sfLaunchingPeer::resetPriorities($namespace);
  }
  
  
  public function increasePriority(BaseObject $object, $namespace = 'home')
  {
    if (!is_string($namespace))
      throw new deppPropelActAsLaunchableException('Namespace can only be a string');

    $l = sfLaunchingPeer::retrieveByModelIdNamespace(get_class($object), $object->getPrimaryKey(), $namespace);
    $next_l = sfLaunchingPeer::retrieveNextByModelIdNamespace(get_class($object), $object->getPrimaryKey(), $namespace);
    deppPropelActAsLaunchableToolkit::swapPriorities($l, $next_l);
  }

  public function decreasePriority(BaseObject $object, $namespace = 'home')
  {
    if (!is_string($namespace))
      throw new deppPropelActAsLaunchableException('Namespace can only be a string');

    $l = sfLaunchingPeer::retrieveByModelIdNamespace(get_class($object), $object->getPrimaryKey(), $namespace);
    $prev_l = sfLaunchingPeer::retrievePrevByModelIdNamespace(get_class($object), $object->getPrimaryKey(), $namespace);
    deppPropelActAsLaunchableToolkit::swapPriorities($prev_l, $l);
  }
  
  /**
   * Delete all launching for a launchable object (delete cascade emulation)
   * 
   * @param  BaseObject  $object
   */
  public function preDelete(BaseObject $object)
  {
    try
    {
      $c = new Criteria();
      $c->add(sfLaunchingPeer::OBJECT_ID, $object->getPrimaryKey());
      $ls = sfLaunchingPeer::doSelect($c);
      foreach ($ls as $l)
      {
        $l->delete();
      }
      sfLaunchingPeer::resetPriorities();
    }
    catch (Exception $e)
    {
      throw new deppPropelActAsLaunchableException(
        'Unable to delete launchable object\'s related launchings records');
    }
  }
  

}