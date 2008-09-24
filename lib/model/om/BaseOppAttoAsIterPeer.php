<?php


abstract class BaseOppAttoAsIterPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'opp_atto_as_iter';

	
	const CLASS_DEFAULT = 'lib.model.OppAttoAsIter';

	
	const NUM_COLUMNS = 3;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ATTO_ID = 'opp_atto_as_iter.ATTO_ID';

	
	const ITER_ID = 'opp_atto_as_iter.ITER_ID';

	
	const DATA = 'opp_atto_as_iter.DATA';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('AttoId', 'IterId', 'Data', ),
		BasePeer::TYPE_COLNAME => array (OppAttoAsIterPeer::ATTO_ID, OppAttoAsIterPeer::ITER_ID, OppAttoAsIterPeer::DATA, ),
		BasePeer::TYPE_FIELDNAME => array ('atto_id', 'iter_id', 'data', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('AttoId' => 0, 'IterId' => 1, 'Data' => 2, ),
		BasePeer::TYPE_COLNAME => array (OppAttoAsIterPeer::ATTO_ID => 0, OppAttoAsIterPeer::ITER_ID => 1, OppAttoAsIterPeer::DATA => 2, ),
		BasePeer::TYPE_FIELDNAME => array ('atto_id' => 0, 'iter_id' => 1, 'data' => 2, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/OppAttoAsIterMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.OppAttoAsIterMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = OppAttoAsIterPeer::getTableMap();
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
		return str_replace(OppAttoAsIterPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(OppAttoAsIterPeer::ATTO_ID);

		$criteria->addSelectColumn(OppAttoAsIterPeer::ITER_ID);

		$criteria->addSelectColumn(OppAttoAsIterPeer::DATA);

	}

	const COUNT = 'COUNT(opp_atto_as_iter.ATTO_ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT opp_atto_as_iter.ATTO_ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppAttoAsIterPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppAttoAsIterPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = OppAttoAsIterPeer::doSelectRS($criteria, $con);
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
		$objects = OppAttoAsIterPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return OppAttoAsIterPeer::populateObjects(OppAttoAsIterPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			OppAttoAsIterPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = OppAttoAsIterPeer::getOMClass();
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
			$criteria->addSelectColumn(OppAttoAsIterPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppAttoAsIterPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppAttoAsIterPeer::ATTO_ID, OppAttoPeer::ID);

		$rs = OppAttoAsIterPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinOppIter(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppAttoAsIterPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppAttoAsIterPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppAttoAsIterPeer::ITER_ID, OppIterPeer::ID);

		$rs = OppAttoAsIterPeer::doSelectRS($criteria, $con);
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

		OppAttoAsIterPeer::addSelectColumns($c);
		$startcol = (OppAttoAsIterPeer::NUM_COLUMNS - OppAttoAsIterPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		OppAttoPeer::addSelectColumns($c);

		$c->addJoin(OppAttoAsIterPeer::ATTO_ID, OppAttoPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppAttoAsIterPeer::getOMClass();

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
										$temp_obj2->addOppAttoAsIter($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initOppAttoAsIters();
				$obj2->addOppAttoAsIter($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinOppIter(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OppAttoAsIterPeer::addSelectColumns($c);
		$startcol = (OppAttoAsIterPeer::NUM_COLUMNS - OppAttoAsIterPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		OppIterPeer::addSelectColumns($c);

		$c->addJoin(OppAttoAsIterPeer::ITER_ID, OppIterPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppAttoAsIterPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = OppIterPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getOppIter(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addOppAttoAsIter($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initOppAttoAsIters();
				$obj2->addOppAttoAsIter($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppAttoAsIterPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppAttoAsIterPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppAttoAsIterPeer::ATTO_ID, OppAttoPeer::ID);

		$criteria->addJoin(OppAttoAsIterPeer::ITER_ID, OppIterPeer::ID);

		$rs = OppAttoAsIterPeer::doSelectRS($criteria, $con);
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

		OppAttoAsIterPeer::addSelectColumns($c);
		$startcol2 = (OppAttoAsIterPeer::NUM_COLUMNS - OppAttoAsIterPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OppAttoPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OppAttoPeer::NUM_COLUMNS;

		OppIterPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + OppIterPeer::NUM_COLUMNS;

		$c->addJoin(OppAttoAsIterPeer::ATTO_ID, OppAttoPeer::ID);

		$c->addJoin(OppAttoAsIterPeer::ITER_ID, OppIterPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppAttoAsIterPeer::getOMClass();


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
					$temp_obj2->addOppAttoAsIter($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initOppAttoAsIters();
				$obj2->addOppAttoAsIter($obj1);
			}


					
			$omClass = OppIterPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getOppIter(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addOppAttoAsIter($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj3->initOppAttoAsIters();
				$obj3->addOppAttoAsIter($obj1);
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
			$criteria->addSelectColumn(OppAttoAsIterPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppAttoAsIterPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppAttoAsIterPeer::ITER_ID, OppIterPeer::ID);

		$rs = OppAttoAsIterPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptOppIter(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppAttoAsIterPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppAttoAsIterPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppAttoAsIterPeer::ATTO_ID, OppAttoPeer::ID);

		$rs = OppAttoAsIterPeer::doSelectRS($criteria, $con);
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

		OppAttoAsIterPeer::addSelectColumns($c);
		$startcol2 = (OppAttoAsIterPeer::NUM_COLUMNS - OppAttoAsIterPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OppIterPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OppIterPeer::NUM_COLUMNS;

		$c->addJoin(OppAttoAsIterPeer::ITER_ID, OppIterPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppAttoAsIterPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = OppIterPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getOppIter(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addOppAttoAsIter($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initOppAttoAsIters();
				$obj2->addOppAttoAsIter($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptOppIter(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OppAttoAsIterPeer::addSelectColumns($c);
		$startcol2 = (OppAttoAsIterPeer::NUM_COLUMNS - OppAttoAsIterPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OppAttoPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OppAttoPeer::NUM_COLUMNS;

		$c->addJoin(OppAttoAsIterPeer::ATTO_ID, OppAttoPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppAttoAsIterPeer::getOMClass();

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
					$temp_obj2->addOppAttoAsIter($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initOppAttoAsIters();
				$obj2->addOppAttoAsIter($obj1);
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
		return OppAttoAsIterPeer::CLASS_DEFAULT;
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
			$comparison = $criteria->getComparison(OppAttoAsIterPeer::ATTO_ID);
			$selectCriteria->add(OppAttoAsIterPeer::ATTO_ID, $criteria->remove(OppAttoAsIterPeer::ATTO_ID), $comparison);

			$comparison = $criteria->getComparison(OppAttoAsIterPeer::ITER_ID);
			$selectCriteria->add(OppAttoAsIterPeer::ITER_ID, $criteria->remove(OppAttoAsIterPeer::ITER_ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(OppAttoAsIterPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(OppAttoAsIterPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof OppAttoAsIter) {

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

			$criteria->add(OppAttoAsIterPeer::ATTO_ID, $vals[0], Criteria::IN);
			$criteria->add(OppAttoAsIterPeer::ITER_ID, $vals[1], Criteria::IN);
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

	
	public static function doValidate(OppAttoAsIter $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(OppAttoAsIterPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(OppAttoAsIterPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(OppAttoAsIterPeer::DATABASE_NAME, OppAttoAsIterPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = OppAttoAsIterPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
            $request->setError($col, $failed->getMessage());
        }
    }

    return $res;
	}

	
	public static function retrieveByPK( $atto_id, $iter_id, $con = null) {
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$criteria = new Criteria();
		$criteria->add(OppAttoAsIterPeer::ATTO_ID, $atto_id);
		$criteria->add(OppAttoAsIterPeer::ITER_ID, $iter_id);
		$v = OppAttoAsIterPeer::doSelect($criteria, $con);

		return !empty($v) ? $v[0] : null;
	}
} 
if (Propel::isInit()) {
			try {
		BaseOppAttoAsIterPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/OppAttoAsIterMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.OppAttoAsIterMapBuilder');
}
