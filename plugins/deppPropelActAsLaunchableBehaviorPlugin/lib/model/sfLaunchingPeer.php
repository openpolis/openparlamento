<?php

/**
 * Subclass for performing query and update operations on the 'sf_launching' table.
 *
 * 
 *
 * @package plugins.deppPropelActAsLaunchableBehaviorPlugin.lib.model
 */ 
class sfLaunchingPeer extends BasesfLaunchingPeer
{
  
  protected static function getAllByNamespaceCriteria($namespace)
  {
    if (is_null($namespace))
      throw new deppPropelActAsLaunchableException('Namespace must be specified');

    $c = new Criteria();
    $c->add(self::NAMESPACE, $namespace);
    $c->addDescendingOrderByColumn(sfLaunchingPeer::PRIORITY);
    return $c;
  }

  protected static function getAllByNamespaceInverseCriteria($namespace)
  {
    if (is_null($namespace))
      throw new deppPropelActAsLaunchableException('Namespace must be specified');

    $c = new Criteria();
    $c->add(self::NAMESPACE, $namespace);
    $c->addAscendingOrderByColumn(sfLaunchingPeer::PRIORITY);
    return $c;
  }

  protected static function getAllNamespaces()
  {
    $c = new Criteria();
    $c->clearSelectColumns();
    $c->addSelectColumn(self::NAMESPACE);
    $c->setDistinct();
    $rs = self::doSelectRS($c);
    $namespaces = array();
    while($rs->next())
      $namespaces []= $rs->getString(1);
  }

  public static function getAllByNamespace($namespace)
  {
    $c = self::getAllByNamespaceCriteria($namespace);
    return self::doSelect($c);
  }

  public static function retrieveByModelIdNamespace($model, $id, $namespace)
  {
    $c = new Criteria();
    $c->add(sfLaunchingPeer::OBJECT_MODEL, $model);
    $c->add(sfLaunchingPeer::OBJECT_ID, $id);
    $c->add(sfLaunchingPeer::NAMESPACE, $namespace);
    return sfLaunchingPeer::doSelectOne($c);
  }

  public static function retrieveByNamespacePriority($namespace, $priority)
  {
    $c = new Criteria();
    $c->add(sfLaunchingPeer::NAMESPACE, $namespace);
    $c->add(sfLaunchingPeer::PRIORITY, $priority);
    return sfLaunchingPeer::doSelectOne($c);
  }


  public static function retrieveNextByModelIdNamespace($model, $id, $namespace)
  {
    $original_launch = self::retrieveByModelIdNamespace($model, $id, $namespace);
    $nextPriority = $original_launch->getPriority() + 1;
    return self::retrieveByNamespacePriority($namespace, $nextPriority);
  }

  public static function retrievePrevByModelIdNamespace($model, $id, $namespace)
  {
    $original_launch = self::retrieveByModelIdNamespace($model, $id, $namespace);
    $prevPriority = $original_launch->getPriority() - 1;
    return self::retrieveByNamespacePriority($namespace, $prevPriority);
  }
  

  public static function getNewLaunchPriority($namespace = null)
  {
    $c = self::getAllByNamespaceCriteria($namespace);
    $last_launch = self::doSelectOne($c);
    if ($last_launch)
      return $last_launch->getPriority() + 1;
    else
      return 0;
  }
  
  
  public static function resetPriorities($namespace = null)
  {

    if (is_null($namespace))
      $namespaces = self::getAllNamespaces();
    else
      $namespaces = array($namespace);
      
    foreach ($namespaces as $namespace)
    {
      $c = self::getAllByNamespaceInverseCriteria($namespace);
      $launches = self::doSelect($c);

      foreach ($launches as $i => $launch)
      {
        $launch->setPriority($i);
        $launch->save();
      }      
    }
    
  }
  
}
