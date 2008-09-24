<?php


abstract class BaseOppCaricaHasAttoPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'opp_carica_has_atto';

	
	const CLASS_DEFAULT = 'lib.model.OppCaricaHasAtto';

	
	const NUM_COLUMNS = 5;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ATTO_ID = 'opp_carica_has_atto.ATTO_ID';

	
	const CARICA_ID = 'opp_carica_has_atto.CARICA_ID';

	
	const TIPO = 'opp_carica_has_atto.TIPO';

	
	const DATA = 'opp_carica_has_atto.DATA';

	
	const URL = 'opp_carica_has_atto.URL';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('AttoId', 'CaricaId', 'Tipo', 'Data', 'Url', ),
		BasePeer::TYPE_COLNAME => array (OppCaricaHasAttoPeer::ATTO_ID, OppCaricaHasAttoPeer::CARICA_ID, OppCaricaHasAttoPeer::TIPO, OppCaricaHasAttoPeer::DATA, OppCaricaHasAttoPeer::URL, ),
		BasePeer::TYPE_FIELDNAME => array ('atto_id', 'carica_id', 'tipo', 'data', 'url', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('AttoId' => 0, 'CaricaId' => 1, 'Tipo' => 2, 'Data' => 3, 'Url' => 4, ),
		BasePeer::TYPE_COLNAME => array (OppCaricaHasAttoPeer::ATTO_ID => 0, OppCaricaHasAttoPeer::CARICA_ID => 1, OppCaricaHasAttoPeer::TIPO => 2, OppCaricaHasAttoPeer::DATA => 3, OppCaricaHasAttoPeer::URL => 4, ),
		BasePeer::TYPE_FIELDNAME => array ('atto_id' => 0, 'carica_id' => 1, 'tipo' => 2, 'data' => 3, 'url' => 4, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/OppCaricaHasAttoMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.OppCaricaHasAttoMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = OppCaricaHasAttoPeer::getTableMap();
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
		return str_replace(OppCaricaHasAttoPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(OppCaricaHasAttoPeer::ATTO_ID);

		$criteria->addSelectColumn(OppCaricaHasAttoPeer::CARICA_ID);

		$criteria->addSelectColumn(OppCaricaHasAttoPeer::TIPO);

		$criteria->addSelectColumn(OppCaricaHasAttoPeer::DATA);

		$criteria->addSelectColumn(OppCaricaHasAttoPeer::URL);

	}

	const COUNT = 'COUNT(opp_carica_has_atto.ATTO_ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT opp_carica_has_atto.ATTO_ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppCaricaHasAttoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppCaricaHasAttoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = OppCaricaHasAttoPeer::doSelectRS($criteria, $con);
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
		$objects = OppCaricaHasAttoPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return OppCaricaHasAttoPeer::populateObjects(OppCaricaHasAttoPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			OppCaricaHasAttoPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = OppCaricaHasAttoPeer::getOMClass();
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
			$criteria->addSelectColumn(OppCaricaHasAttoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppCaricaHasAttoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppCaricaHasAttoPeer::ATTO_ID, OppAttoPeer::ID);

		$rs = OppCaricaHasAttoPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinOppCarica(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppCaricaHasAttoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppCaricaHasAttoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppCaricaHasAttoPeer::CARICA_ID, OppCaricaPeer::ID);

		$rs = OppCaricaHasAttoPeer::doSelectRS($criteria, $con);
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

		OppCaricaHasAttoPeer::addSelectColumns($c);
		$startcol = (OppCaricaHasAttoPeer::NUM_COLUMNS - OppCaricaHasAttoPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		OppAttoPeer::addSelectColumns($c);

		$c->addJoin(OppCaricaHasAttoPeer::ATTO_ID, OppAttoPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppCaricaHasAttoPeer::getOMClass();

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
										$temp_obj2->addOppCaricaHasAtto($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initOppCaricaHasAttos();
				$obj2->addOppCaricaHasAtto($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinOppCarica(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OppCaricaHasAttoPeer::addSelectColumns($c);
		$startcol = (OppCaricaHasAttoPeer::NUM_COLUMNS - OppCaricaHasAttoPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		OppCaricaPeer::addSelectColumns($c);

		$c->addJoin(OppCaricaHasAttoPeer::CARICA_ID, OppCaricaPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppCaricaHasAttoPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = OppCaricaPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getOppCarica(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addOppCaricaHasAtto($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initOppCaricaHasAttos();
				$obj2->addOppCaricaHasAtto($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppCaricaHasAttoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppCaricaHasAttoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppCaricaHasAttoPeer::ATTO_ID, OppAttoPeer::ID);

		$criteria->addJoin(OppCaricaHasAttoPeer::CARICA_ID, OppCaricaPeer::ID);

		$rs = OppCaricaHasAttoPeer::doSelectRS($criteria, $con);
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

		OppCaricaHasAttoPeer::addSelectColumns($c);
		$startcol2 = (OppCaricaHasAttoPeer::NUM_COLUMNS - OppCaricaHasAttoPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OppAttoPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OppAttoPeer::NUM_COLUMNS;

		OppCaricaPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + OppCaricaPeer::NUM_COLUMNS;

		$c->addJoin(OppCaricaHasAttoPeer::ATTO_ID, OppAttoPeer::ID);

		$c->addJoin(OppCaricaHasAttoPeer::CARICA_ID, OppCaricaPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppCaricaHasAttoPeer::getOMClass();


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
					$temp_obj2->addOppCaricaHasAtto($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initOppCaricaHasAttos();
				$obj2->addOppCaricaHasAtto($obj1);
			}


					
			$omClass = OppCaricaPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getOppCarica(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addOppCaricaHasAtto($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj3->initOppCaricaHasAttos();
				$obj3->addOppCaricaHasAtto($obj1);
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
			$criteria->addSelectColumn(OppCaricaHasAttoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppCaricaHasAttoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppCaricaHasAttoPeer::CARICA_ID, OppCaricaPeer::ID);

		$rs = OppCaricaHasAttoPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptOppCarica(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppCaricaHasAttoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppCaricaHasAttoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppCaricaHasAttoPeer::ATTO_ID, OppAttoPeer::ID);

		$rs = OppCaricaHasAttoPeer::doSelectRS($criteria, $con);
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

		OppCaricaHasAttoPeer::addSelectColumns($c);
		$startcol2 = (OppCaricaHasAttoPeer::NUM_COLUMNS - OppCaricaHasAttoPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OppCaricaPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OppCaricaPeer::NUM_COLUMNS;

		$c->addJoin(OppCaricaHasAttoPeer::CARICA_ID, OppCaricaPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppCaricaHasAttoPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = OppCaricaPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getOppCarica(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addOppCaricaHasAtto($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initOppCaricaHasAttos();
				$obj2->addOppCaricaHasAtto($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptOppCarica(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OppCaricaHasAttoPeer::addSelectColumns($c);
		$startcol2 = (OppCaricaHasAttoPeer::NUM_COLUMNS - OppCaricaHasAttoPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OppAttoPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OppAttoPeer::NUM_COLUMNS;

		$c->addJoin(OppCaricaHasAttoPeer::ATTO_ID, OppAttoPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppCaricaHasAttoPeer::getOMClass();

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
					$temp_obj2->addOppCaricaHasAtto($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initOppCaricaHasAttos();
				$obj2->addOppCaricaHasAtto($obj1);
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
		return OppCaricaHasAttoPeer::CLASS_DEFAULT;
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
			$comparison = $criteria->getComparison(OppCaricaHasAttoPeer::ATTO_ID);
			$selectCriteria->add(OppCaricaHasAttoPeer::ATTO_ID, $criteria->remove(OppCaricaHasAttoPeer::ATTO_ID), $comparison);

			$comparison = $criteria->getComparison(OppCaricaHasAttoPeer::CARICA_ID);
			$selectCriteria->add(OppCaricaHasAttoPeer::CARICA_ID, $criteria->remove(OppCaricaHasAttoPeer::CARICA_ID), $comparison);

			$comparison = $criteria->getComparison(OppCaricaHasAttoPeer::TIPO);
			$selectCriteria->add(OppCaricaHasAttoPeer::TIPO, $criteria->remove(OppCaricaHasAttoPeer::TIPO), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(OppCaricaHasAttoPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(OppCaricaHasAttoPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof OppCaricaHasAtto) {

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
				$vals[2][] = $value[2];
			}

			$criteria->add(OppCaricaHasAttoPeer::ATTO_ID, $vals[0], Criteria::IN);
			$criteria->add(OppCaricaHasAttoPeer::CARICA_ID, $vals[1], Criteria::IN);
			$criteria->add(OppCaricaHasAttoPeer::TIPO, $vals[2], Criteria::IN);
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

	
	public static function doValidate(OppCaricaHasAtto $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(OppCaricaHasAttoPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(OppCaricaHasAttoPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(OppCaricaHasAttoPeer::DATABASE_NAME, OppCaricaHasAttoPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = OppCaricaHasAttoPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
            $request->setError($col, $failed->getMessage());
        }
    }

    return $res;
	}

	
	public static function retrieveByPK( $atto_id, $carica_id, $tipo, $con = null) {
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$criteria = new Criteria();
		$criteria->add(OppCaricaHasAttoPeer::ATTO_ID, $atto_id);
		$criteria->add(OppCaricaHasAttoPeer::CARICA_ID, $carica_id);
		$criteria->add(OppCaricaHasAttoPeer::TIPO, $tipo);
		$v = OppCaricaHasAttoPeer::doSelect($criteria, $con);

		return !empty($v) ? $v[0] : null;
	}
} 
if (Propel::isInit()) {
			try {
		BaseOppCaricaHasAttoPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/OppCaricaHasAttoMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.OppCaricaHasAttoMapBuilder');
}
