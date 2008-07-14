<?php


abstract class BaseOppAttoHasTeseoPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'opp_atto_has_teseo';

	
	const CLASS_DEFAULT = 'lib.model.OppAttoHasTeseo';

	
	const NUM_COLUMNS = 2;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ATTO_ID = 'opp_atto_has_teseo.ATTO_ID';

	
	const TESEO_ID = 'opp_atto_has_teseo.TESEO_ID';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('AttoId', 'TeseoId', ),
		BasePeer::TYPE_COLNAME => array (OppAttoHasTeseoPeer::ATTO_ID, OppAttoHasTeseoPeer::TESEO_ID, ),
		BasePeer::TYPE_FIELDNAME => array ('atto_id', 'teseo_id', ),
		BasePeer::TYPE_NUM => array (0, 1, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('AttoId' => 0, 'TeseoId' => 1, ),
		BasePeer::TYPE_COLNAME => array (OppAttoHasTeseoPeer::ATTO_ID => 0, OppAttoHasTeseoPeer::TESEO_ID => 1, ),
		BasePeer::TYPE_FIELDNAME => array ('atto_id' => 0, 'teseo_id' => 1, ),
		BasePeer::TYPE_NUM => array (0, 1, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/OppAttoHasTeseoMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.OppAttoHasTeseoMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = OppAttoHasTeseoPeer::getTableMap();
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
		return str_replace(OppAttoHasTeseoPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(OppAttoHasTeseoPeer::ATTO_ID);

		$criteria->addSelectColumn(OppAttoHasTeseoPeer::TESEO_ID);

	}

	const COUNT = 'COUNT(opp_atto_has_teseo.ATTO_ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT opp_atto_has_teseo.ATTO_ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppAttoHasTeseoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppAttoHasTeseoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = OppAttoHasTeseoPeer::doSelectRS($criteria, $con);
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
		$objects = OppAttoHasTeseoPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return OppAttoHasTeseoPeer::populateObjects(OppAttoHasTeseoPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			OppAttoHasTeseoPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = OppAttoHasTeseoPeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}

	
	public static function doCountJoinOppAtto(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppAttoHasTeseoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppAttoHasTeseoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppAttoHasTeseoPeer::ATTO_ID, OppAttoPeer::ID);

		$rs = OppAttoHasTeseoPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinOppTeseo(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppAttoHasTeseoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppAttoHasTeseoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppAttoHasTeseoPeer::TESEO_ID, OppTeseoPeer::ID);

		$rs = OppAttoHasTeseoPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinOppAtto(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OppAttoHasTeseoPeer::addSelectColumns($c);
		$startcol = (OppAttoHasTeseoPeer::NUM_COLUMNS - OppAttoHasTeseoPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		OppAttoPeer::addSelectColumns($c);

		$c->addJoin(OppAttoHasTeseoPeer::ATTO_ID, OppAttoPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppAttoHasTeseoPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = OppAttoPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getOppAtto(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addOppAttoHasTeseo($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initOppAttoHasTeseos();
				$obj2->addOppAttoHasTeseo($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinOppTeseo(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OppAttoHasTeseoPeer::addSelectColumns($c);
		$startcol = (OppAttoHasTeseoPeer::NUM_COLUMNS - OppAttoHasTeseoPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		OppTeseoPeer::addSelectColumns($c);

		$c->addJoin(OppAttoHasTeseoPeer::TESEO_ID, OppTeseoPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppAttoHasTeseoPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = OppTeseoPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getOppTeseo(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addOppAttoHasTeseo($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initOppAttoHasTeseos();
				$obj2->addOppAttoHasTeseo($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppAttoHasTeseoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppAttoHasTeseoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppAttoHasTeseoPeer::ATTO_ID, OppAttoPeer::ID);

		$criteria->addJoin(OppAttoHasTeseoPeer::TESEO_ID, OppTeseoPeer::ID);

		$rs = OppAttoHasTeseoPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinAll(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OppAttoHasTeseoPeer::addSelectColumns($c);
		$startcol2 = (OppAttoHasTeseoPeer::NUM_COLUMNS - OppAttoHasTeseoPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OppAttoPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OppAttoPeer::NUM_COLUMNS;

		OppTeseoPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + OppTeseoPeer::NUM_COLUMNS;

		$c->addJoin(OppAttoHasTeseoPeer::ATTO_ID, OppAttoPeer::ID);

		$c->addJoin(OppAttoHasTeseoPeer::TESEO_ID, OppTeseoPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppAttoHasTeseoPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


					
			$omClass = OppAttoPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getOppAtto(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addOppAttoHasTeseo($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initOppAttoHasTeseos();
				$obj2->addOppAttoHasTeseo($obj1);
			}


					
			$omClass = OppTeseoPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getOppTeseo(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addOppAttoHasTeseo($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj3->initOppAttoHasTeseos();
				$obj3->addOppAttoHasTeseo($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAllExceptOppAtto(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppAttoHasTeseoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppAttoHasTeseoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppAttoHasTeseoPeer::TESEO_ID, OppTeseoPeer::ID);

		$rs = OppAttoHasTeseoPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptOppTeseo(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppAttoHasTeseoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppAttoHasTeseoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppAttoHasTeseoPeer::ATTO_ID, OppAttoPeer::ID);

		$rs = OppAttoHasTeseoPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinAllExceptOppAtto(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OppAttoHasTeseoPeer::addSelectColumns($c);
		$startcol2 = (OppAttoHasTeseoPeer::NUM_COLUMNS - OppAttoHasTeseoPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OppTeseoPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OppTeseoPeer::NUM_COLUMNS;

		$c->addJoin(OppAttoHasTeseoPeer::TESEO_ID, OppTeseoPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppAttoHasTeseoPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = OppTeseoPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getOppTeseo(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addOppAttoHasTeseo($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initOppAttoHasTeseos();
				$obj2->addOppAttoHasTeseo($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptOppTeseo(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OppAttoHasTeseoPeer::addSelectColumns($c);
		$startcol2 = (OppAttoHasTeseoPeer::NUM_COLUMNS - OppAttoHasTeseoPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OppAttoPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OppAttoPeer::NUM_COLUMNS;

		$c->addJoin(OppAttoHasTeseoPeer::ATTO_ID, OppAttoPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppAttoHasTeseoPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = OppAttoPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getOppAtto(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addOppAttoHasTeseo($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initOppAttoHasTeseos();
				$obj2->addOppAttoHasTeseo($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}

	
	public static function getTableMap()
	{
		return Propel::getDatabaseMap(self::DATABASE_NAME)->getTable(self::TABLE_NAME);
	}

	
	public static function getOMClass()
	{
		return OppAttoHasTeseoPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}


				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; 
			$comparison = $criteria->getComparison(OppAttoHasTeseoPeer::ATTO_ID);
			$selectCriteria->add(OppAttoHasTeseoPeer::ATTO_ID, $criteria->remove(OppAttoHasTeseoPeer::ATTO_ID), $comparison);

			$comparison = $criteria->getComparison(OppAttoHasTeseoPeer::TESEO_ID);
			$selectCriteria->add(OppAttoHasTeseoPeer::TESEO_ID, $criteria->remove(OppAttoHasTeseoPeer::TESEO_ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		return BasePeer::doUpdate($selectCriteria, $criteria, $con);
	}

	
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$affectedRows = 0; 		try {
									$con->begin();
			$affectedRows += BasePeer::doDeleteAll(OppAttoHasTeseoPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(OppAttoHasTeseoPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof OppAttoHasTeseo) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
												if(count($values) == count($values, COUNT_RECURSIVE))
			{
								$values = array($values);
			}
			$vals = array();
			foreach($values as $value)
			{

				$vals[0][] = $value[0];
				$vals[1][] = $value[1];
			}

			$criteria->add(OppAttoHasTeseoPeer::ATTO_ID, $vals[0], Criteria::IN);
			$criteria->add(OppAttoHasTeseoPeer::TESEO_ID, $vals[1], Criteria::IN);
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

	
	public static function doValidate(OppAttoHasTeseo $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(OppAttoHasTeseoPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(OppAttoHasTeseoPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(OppAttoHasTeseoPeer::DATABASE_NAME, OppAttoHasTeseoPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = OppAttoHasTeseoPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
            $request->setError($col, $failed->getMessage());
        }
    }

    return $res;
	}

	
	public static function retrieveByPK( $atto_id, $teseo_id, $con = null) {
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$criteria = new Criteria();
		$criteria->add(OppAttoHasTeseoPeer::ATTO_ID, $atto_id);
		$criteria->add(OppAttoHasTeseoPeer::TESEO_ID, $teseo_id);
		$v = OppAttoHasTeseoPeer::doSelect($criteria, $con);

		return !empty($v) ? $v[0] : null;
	}
} 
if (Propel::isInit()) {
			try {
		BaseOppAttoHasTeseoPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/OppAttoHasTeseoMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.OppAttoHasTeseoMapBuilder');
}
