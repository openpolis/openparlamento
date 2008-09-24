<?php


abstract class BaseOppAttoHasSedePeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'opp_atto_has_sede';

	
	const CLASS_DEFAULT = 'lib.model.OppAttoHasSede';

	
	const NUM_COLUMNS = 3;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ATTO_ID = 'opp_atto_has_sede.ATTO_ID';

	
	const SEDE_ID = 'opp_atto_has_sede.SEDE_ID';

	
	const TIPO = 'opp_atto_has_sede.TIPO';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('AttoId', 'SedeId', 'Tipo', ),
		BasePeer::TYPE_COLNAME => array (OppAttoHasSedePeer::ATTO_ID, OppAttoHasSedePeer::SEDE_ID, OppAttoHasSedePeer::TIPO, ),
		BasePeer::TYPE_FIELDNAME => array ('atto_id', 'sede_id', 'tipo', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('AttoId' => 0, 'SedeId' => 1, 'Tipo' => 2, ),
		BasePeer::TYPE_COLNAME => array (OppAttoHasSedePeer::ATTO_ID => 0, OppAttoHasSedePeer::SEDE_ID => 1, OppAttoHasSedePeer::TIPO => 2, ),
		BasePeer::TYPE_FIELDNAME => array ('atto_id' => 0, 'sede_id' => 1, 'tipo' => 2, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/OppAttoHasSedeMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.OppAttoHasSedeMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = OppAttoHasSedePeer::getTableMap();
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
		return str_replace(OppAttoHasSedePeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(OppAttoHasSedePeer::ATTO_ID);

		$criteria->addSelectColumn(OppAttoHasSedePeer::SEDE_ID);

		$criteria->addSelectColumn(OppAttoHasSedePeer::TIPO);

	}

	const COUNT = 'COUNT(opp_atto_has_sede.ATTO_ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT opp_atto_has_sede.ATTO_ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppAttoHasSedePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppAttoHasSedePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = OppAttoHasSedePeer::doSelectRS($criteria, $con);
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
		$objects = OppAttoHasSedePeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return OppAttoHasSedePeer::populateObjects(OppAttoHasSedePeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			OppAttoHasSedePeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = OppAttoHasSedePeer::getOMClass();
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
			$criteria->addSelectColumn(OppAttoHasSedePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppAttoHasSedePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppAttoHasSedePeer::ATTO_ID, OppAttoPeer::ID);

		$rs = OppAttoHasSedePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinOppSede(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppAttoHasSedePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppAttoHasSedePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppAttoHasSedePeer::SEDE_ID, OppSedePeer::ID);

		$rs = OppAttoHasSedePeer::doSelectRS($criteria, $con);
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

		OppAttoHasSedePeer::addSelectColumns($c);
		$startcol = (OppAttoHasSedePeer::NUM_COLUMNS - OppAttoHasSedePeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		OppAttoPeer::addSelectColumns($c);

		$c->addJoin(OppAttoHasSedePeer::ATTO_ID, OppAttoPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppAttoHasSedePeer::getOMClass();

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
										$temp_obj2->addOppAttoHasSede($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initOppAttoHasSedes();
				$obj2->addOppAttoHasSede($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinOppSede(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OppAttoHasSedePeer::addSelectColumns($c);
		$startcol = (OppAttoHasSedePeer::NUM_COLUMNS - OppAttoHasSedePeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		OppSedePeer::addSelectColumns($c);

		$c->addJoin(OppAttoHasSedePeer::SEDE_ID, OppSedePeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppAttoHasSedePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = OppSedePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getOppSede(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addOppAttoHasSede($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initOppAttoHasSedes();
				$obj2->addOppAttoHasSede($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppAttoHasSedePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppAttoHasSedePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppAttoHasSedePeer::ATTO_ID, OppAttoPeer::ID);

		$criteria->addJoin(OppAttoHasSedePeer::SEDE_ID, OppSedePeer::ID);

		$rs = OppAttoHasSedePeer::doSelectRS($criteria, $con);
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

		OppAttoHasSedePeer::addSelectColumns($c);
		$startcol2 = (OppAttoHasSedePeer::NUM_COLUMNS - OppAttoHasSedePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OppAttoPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OppAttoPeer::NUM_COLUMNS;

		OppSedePeer::addSelectColumns($c);
		$startcol4 = $startcol3 + OppSedePeer::NUM_COLUMNS;

		$c->addJoin(OppAttoHasSedePeer::ATTO_ID, OppAttoPeer::ID);

		$c->addJoin(OppAttoHasSedePeer::SEDE_ID, OppSedePeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppAttoHasSedePeer::getOMClass();


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
					$temp_obj2->addOppAttoHasSede($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initOppAttoHasSedes();
				$obj2->addOppAttoHasSede($obj1);
			}


					
			$omClass = OppSedePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getOppSede(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addOppAttoHasSede($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj3->initOppAttoHasSedes();
				$obj3->addOppAttoHasSede($obj1);
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
			$criteria->addSelectColumn(OppAttoHasSedePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppAttoHasSedePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppAttoHasSedePeer::SEDE_ID, OppSedePeer::ID);

		$rs = OppAttoHasSedePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptOppSede(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppAttoHasSedePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppAttoHasSedePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppAttoHasSedePeer::ATTO_ID, OppAttoPeer::ID);

		$rs = OppAttoHasSedePeer::doSelectRS($criteria, $con);
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

		OppAttoHasSedePeer::addSelectColumns($c);
		$startcol2 = (OppAttoHasSedePeer::NUM_COLUMNS - OppAttoHasSedePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OppSedePeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OppSedePeer::NUM_COLUMNS;

		$c->addJoin(OppAttoHasSedePeer::SEDE_ID, OppSedePeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppAttoHasSedePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = OppSedePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getOppSede(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addOppAttoHasSede($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initOppAttoHasSedes();
				$obj2->addOppAttoHasSede($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptOppSede(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OppAttoHasSedePeer::addSelectColumns($c);
		$startcol2 = (OppAttoHasSedePeer::NUM_COLUMNS - OppAttoHasSedePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OppAttoPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OppAttoPeer::NUM_COLUMNS;

		$c->addJoin(OppAttoHasSedePeer::ATTO_ID, OppAttoPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppAttoHasSedePeer::getOMClass();

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
					$temp_obj2->addOppAttoHasSede($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initOppAttoHasSedes();
				$obj2->addOppAttoHasSede($obj1);
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
		return OppAttoHasSedePeer::CLASS_DEFAULT;
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
			$comparison = $criteria->getComparison(OppAttoHasSedePeer::ATTO_ID);
			$selectCriteria->add(OppAttoHasSedePeer::ATTO_ID, $criteria->remove(OppAttoHasSedePeer::ATTO_ID), $comparison);

			$comparison = $criteria->getComparison(OppAttoHasSedePeer::SEDE_ID);
			$selectCriteria->add(OppAttoHasSedePeer::SEDE_ID, $criteria->remove(OppAttoHasSedePeer::SEDE_ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(OppAttoHasSedePeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(OppAttoHasSedePeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof OppAttoHasSede) {

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

			$criteria->add(OppAttoHasSedePeer::ATTO_ID, $vals[0], Criteria::IN);
			$criteria->add(OppAttoHasSedePeer::SEDE_ID, $vals[1], Criteria::IN);
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

	
	public static function doValidate(OppAttoHasSede $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(OppAttoHasSedePeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(OppAttoHasSedePeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(OppAttoHasSedePeer::DATABASE_NAME, OppAttoHasSedePeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = OppAttoHasSedePeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
            $request->setError($col, $failed->getMessage());
        }
    }

    return $res;
	}

	
	public static function retrieveByPK( $atto_id, $sede_id, $con = null) {
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$criteria = new Criteria();
		$criteria->add(OppAttoHasSedePeer::ATTO_ID, $atto_id);
		$criteria->add(OppAttoHasSedePeer::SEDE_ID, $sede_id);
		$v = OppAttoHasSedePeer::doSelect($criteria, $con);

		return !empty($v) ? $v[0] : null;
	}
} 
if (Propel::isInit()) {
			try {
		BaseOppAttoHasSedePeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/OppAttoHasSedeMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.OppAttoHasSedeMapBuilder');
}
