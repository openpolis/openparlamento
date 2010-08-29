<?php


abstract class BasesfPriorityPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'sf_priority';

	
	const CLASS_DEFAULT = 'plugins.deppPropelActAsPrioritisableBehaviorPlugin.lib.model.sfPriority';

	
	const NUM_COLUMNS = 7;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'sf_priority.ID';

	
	const PRIORITISABLE_MODEL = 'sf_priority.PRIORITISABLE_MODEL';

	
	const PRIORITISABLE_ID = 'sf_priority.PRIORITISABLE_ID';

	
	const USER_ID = 'sf_priority.USER_ID';

	
	const PRIORITY = 'sf_priority.PRIORITY';

	
	const CREATED_AT = 'sf_priority.CREATED_AT';

	
	const UPDATED_AT = 'sf_priority.UPDATED_AT';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'PrioritisableModel', 'PrioritisableId', 'UserId', 'Priority', 'CreatedAt', 'UpdatedAt', ),
		BasePeer::TYPE_COLNAME => array (sfPriorityPeer::ID, sfPriorityPeer::PRIORITISABLE_MODEL, sfPriorityPeer::PRIORITISABLE_ID, sfPriorityPeer::USER_ID, sfPriorityPeer::PRIORITY, sfPriorityPeer::CREATED_AT, sfPriorityPeer::UPDATED_AT, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'prioritisable_model', 'prioritisable_id', 'user_id', 'priority', 'created_at', 'updated_at', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'PrioritisableModel' => 1, 'PrioritisableId' => 2, 'UserId' => 3, 'Priority' => 4, 'CreatedAt' => 5, 'UpdatedAt' => 6, ),
		BasePeer::TYPE_COLNAME => array (sfPriorityPeer::ID => 0, sfPriorityPeer::PRIORITISABLE_MODEL => 1, sfPriorityPeer::PRIORITISABLE_ID => 2, sfPriorityPeer::USER_ID => 3, sfPriorityPeer::PRIORITY => 4, sfPriorityPeer::CREATED_AT => 5, sfPriorityPeer::UPDATED_AT => 6, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'prioritisable_model' => 1, 'prioritisable_id' => 2, 'user_id' => 3, 'priority' => 4, 'created_at' => 5, 'updated_at' => 6, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'plugins/deppPropelActAsPrioritisableBehaviorPlugin/lib/model/map/sfPriorityMapBuilder.php';
		return BasePeer::getMapBuilder('plugins.deppPropelActAsPrioritisableBehaviorPlugin.lib.model.map.sfPriorityMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = sfPriorityPeer::getTableMap();
			$columns = $map->getColumns();
			$nameMap = array();
			foreach ($columns as $column) {
				$nameMap[$column->getPhpName()] = $column->getColumnName();
			}
			self::$phpNameMap = $nameMap;
		}
		return self::$phpNameMap;
	}
	
	static public function translateFieldName($name, $fromType, $toType)
	{
		$toNames = self::getFieldNames($toType);
		$key = isset(self::$fieldKeys[$fromType][$name]) ? self::$fieldKeys[$fromType][$name] : null;
		if ($key === null) {
			throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(self::$fieldKeys[$fromType], true));
		}
		return $toNames[$key];
	}

	

	static public function getFieldNames($type = BasePeer::TYPE_PHPNAME)
	{
		if (!array_key_exists($type, self::$fieldNames)) {
			throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants TYPE_PHPNAME, TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM. ' . $type . ' was given.');
		}
		return self::$fieldNames[$type];
	}

	
	public static function alias($alias, $column)
	{
		return str_replace(sfPriorityPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(sfPriorityPeer::ID);

		$criteria->addSelectColumn(sfPriorityPeer::PRIORITISABLE_MODEL);

		$criteria->addSelectColumn(sfPriorityPeer::PRIORITISABLE_ID);

		$criteria->addSelectColumn(sfPriorityPeer::USER_ID);

		$criteria->addSelectColumn(sfPriorityPeer::PRIORITY);

		$criteria->addSelectColumn(sfPriorityPeer::CREATED_AT);

		$criteria->addSelectColumn(sfPriorityPeer::UPDATED_AT);

	}

	const COUNT = 'COUNT(sf_priority.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT sf_priority.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(sfPriorityPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(sfPriorityPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = sfPriorityPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}
	
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = sfPriorityPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return sfPriorityPeer::populateObjects(sfPriorityPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BasesfPriorityPeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BasesfPriorityPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			sfPriorityPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = sfPriorityPeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}
	
	public static function getTableMap()
	{
		return Propel::getDatabaseMap(self::DATABASE_NAME)->getTable(self::TABLE_NAME);
	}

	
	public static function getOMClass()
	{
		return sfPriorityPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BasesfPriorityPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasesfPriorityPeer', $values, $con);
      if (false !== $ret)
      {
        return $ret;
      }
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(sfPriorityPeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BasesfPriorityPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BasesfPriorityPeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BasesfPriorityPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasesfPriorityPeer', $values, $con);
      if (false !== $ret)
      {
        return $ret;
      }
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; 
			$comparison = $criteria->getComparison(sfPriorityPeer::ID);
			$selectCriteria->add(sfPriorityPeer::ID, $criteria->remove(sfPriorityPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BasesfPriorityPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BasesfPriorityPeer', $values, $con, $ret);
    }

    return $ret;
  }

	
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$affectedRows = 0; 		try {
									$con->begin();
			$affectedRows += BasePeer::doDeleteAll(sfPriorityPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	 public static function doDelete($values, $con = null)
	 {
		if ($con === null) {
			$con = Propel::getConnection(sfPriorityPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof sfPriority) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(sfPriorityPeer::ID, (array) $values, Criteria::IN);
		}

				$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; 
		try {
									$con->begin();
			
			$affectedRows += BasePeer::doDelete($criteria, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public static function doValidate(sfPriority $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(sfPriorityPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(sfPriorityPeer::TABLE_NAME);

			if (! is_array($cols)) {
				$cols = array($cols);
			}

			foreach($cols as $colName) {
				if ($tableMap->containsColumn($colName)) {
					$get = 'get' . $tableMap->getColumn($colName)->getPhpName();
					$columns[$colName] = $obj->$get();
				}
			}
		} else {

		}

		$res =  BasePeer::doValidate(sfPriorityPeer::DATABASE_NAME, sfPriorityPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = sfPriorityPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
            $request->setError($col, $failed->getMessage());
        }
    }

    return $res;
	}

	
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(sfPriorityPeer::DATABASE_NAME);

		$criteria->add(sfPriorityPeer::ID, $pk);


		$v = sfPriorityPeer::doSelect($criteria, $con);

		return !empty($v) > 0 ? $v[0] : null;
	}

	
	public static function retrieveByPKs($pks, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$objs = null;
		if (empty($pks)) {
			$objs = array();
		} else {
			$criteria = new Criteria();
			$criteria->add(sfPriorityPeer::ID, $pks, Criteria::IN);
			$objs = sfPriorityPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BasesfPriorityPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'plugins/deppPropelActAsPrioritisableBehaviorPlugin/lib/model/map/sfPriorityMapBuilder.php';
	Propel::registerMapBuilder('plugins.deppPropelActAsPrioritisableBehaviorPlugin.lib.model.map.sfPriorityMapBuilder');
}
