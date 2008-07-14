<?php


abstract class BaseOppCaricaHasGruppoPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'opp_carica_has_gruppo';

	
	const CLASS_DEFAULT = 'lib.model.OppCaricaHasGruppo';

	
	const NUM_COLUMNS = 5;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const CARICA_ID = 'opp_carica_has_gruppo.CARICA_ID';

	
	const GRUPPO_ID = 'opp_carica_has_gruppo.GRUPPO_ID';

	
	const DATA_INIZIO = 'opp_carica_has_gruppo.DATA_INIZIO';

	
	const DATA_FINE = 'opp_carica_has_gruppo.DATA_FINE';

	
	const RIBELLE = 'opp_carica_has_gruppo.RIBELLE';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('CaricaId', 'GruppoId', 'DataInizio', 'DataFine', 'Ribelle', ),
		BasePeer::TYPE_COLNAME => array (OppCaricaHasGruppoPeer::CARICA_ID, OppCaricaHasGruppoPeer::GRUPPO_ID, OppCaricaHasGruppoPeer::DATA_INIZIO, OppCaricaHasGruppoPeer::DATA_FINE, OppCaricaHasGruppoPeer::RIBELLE, ),
		BasePeer::TYPE_FIELDNAME => array ('carica_id', 'gruppo_id', 'data_inizio', 'data_fine', 'ribelle', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('CaricaId' => 0, 'GruppoId' => 1, 'DataInizio' => 2, 'DataFine' => 3, 'Ribelle' => 4, ),
		BasePeer::TYPE_COLNAME => array (OppCaricaHasGruppoPeer::CARICA_ID => 0, OppCaricaHasGruppoPeer::GRUPPO_ID => 1, OppCaricaHasGruppoPeer::DATA_INIZIO => 2, OppCaricaHasGruppoPeer::DATA_FINE => 3, OppCaricaHasGruppoPeer::RIBELLE => 4, ),
		BasePeer::TYPE_FIELDNAME => array ('carica_id' => 0, 'gruppo_id' => 1, 'data_inizio' => 2, 'data_fine' => 3, 'ribelle' => 4, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/OppCaricaHasGruppoMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.OppCaricaHasGruppoMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = OppCaricaHasGruppoPeer::getTableMap();
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
		return str_replace(OppCaricaHasGruppoPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(OppCaricaHasGruppoPeer::CARICA_ID);

		$criteria->addSelectColumn(OppCaricaHasGruppoPeer::GRUPPO_ID);

		$criteria->addSelectColumn(OppCaricaHasGruppoPeer::DATA_INIZIO);

		$criteria->addSelectColumn(OppCaricaHasGruppoPeer::DATA_FINE);

		$criteria->addSelectColumn(OppCaricaHasGruppoPeer::RIBELLE);

	}

	const COUNT = 'COUNT(opp_carica_has_gruppo.CARICA_ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT opp_carica_has_gruppo.CARICA_ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppCaricaHasGruppoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppCaricaHasGruppoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = OppCaricaHasGruppoPeer::doSelectRS($criteria, $con);
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
		$objects = OppCaricaHasGruppoPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return OppCaricaHasGruppoPeer::populateObjects(OppCaricaHasGruppoPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			OppCaricaHasGruppoPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = OppCaricaHasGruppoPeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}

	
	public static function doCountJoinOppCarica(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppCaricaHasGruppoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppCaricaHasGruppoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppCaricaHasGruppoPeer::CARICA_ID, OppCaricaPeer::ID);

		$rs = OppCaricaHasGruppoPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinOppGruppo(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppCaricaHasGruppoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppCaricaHasGruppoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppCaricaHasGruppoPeer::GRUPPO_ID, OppGruppoPeer::ID);

		$rs = OppCaricaHasGruppoPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinOppCarica(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OppCaricaHasGruppoPeer::addSelectColumns($c);
		$startcol = (OppCaricaHasGruppoPeer::NUM_COLUMNS - OppCaricaHasGruppoPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		OppCaricaPeer::addSelectColumns($c);

		$c->addJoin(OppCaricaHasGruppoPeer::CARICA_ID, OppCaricaPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppCaricaHasGruppoPeer::getOMClass();

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
										$temp_obj2->addOppCaricaHasGruppo($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initOppCaricaHasGruppos();
				$obj2->addOppCaricaHasGruppo($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinOppGruppo(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OppCaricaHasGruppoPeer::addSelectColumns($c);
		$startcol = (OppCaricaHasGruppoPeer::NUM_COLUMNS - OppCaricaHasGruppoPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		OppGruppoPeer::addSelectColumns($c);

		$c->addJoin(OppCaricaHasGruppoPeer::GRUPPO_ID, OppGruppoPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppCaricaHasGruppoPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = OppGruppoPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getOppGruppo(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addOppCaricaHasGruppo($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initOppCaricaHasGruppos();
				$obj2->addOppCaricaHasGruppo($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppCaricaHasGruppoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppCaricaHasGruppoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppCaricaHasGruppoPeer::CARICA_ID, OppCaricaPeer::ID);

		$criteria->addJoin(OppCaricaHasGruppoPeer::GRUPPO_ID, OppGruppoPeer::ID);

		$rs = OppCaricaHasGruppoPeer::doSelectRS($criteria, $con);
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

		OppCaricaHasGruppoPeer::addSelectColumns($c);
		$startcol2 = (OppCaricaHasGruppoPeer::NUM_COLUMNS - OppCaricaHasGruppoPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OppCaricaPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OppCaricaPeer::NUM_COLUMNS;

		OppGruppoPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + OppGruppoPeer::NUM_COLUMNS;

		$c->addJoin(OppCaricaHasGruppoPeer::CARICA_ID, OppCaricaPeer::ID);

		$c->addJoin(OppCaricaHasGruppoPeer::GRUPPO_ID, OppGruppoPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppCaricaHasGruppoPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


					
			$omClass = OppCaricaPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getOppCarica(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addOppCaricaHasGruppo($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initOppCaricaHasGruppos();
				$obj2->addOppCaricaHasGruppo($obj1);
			}


					
			$omClass = OppGruppoPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getOppGruppo(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addOppCaricaHasGruppo($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj3->initOppCaricaHasGruppos();
				$obj3->addOppCaricaHasGruppo($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAllExceptOppCarica(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppCaricaHasGruppoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppCaricaHasGruppoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppCaricaHasGruppoPeer::GRUPPO_ID, OppGruppoPeer::ID);

		$rs = OppCaricaHasGruppoPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptOppGruppo(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppCaricaHasGruppoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppCaricaHasGruppoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppCaricaHasGruppoPeer::CARICA_ID, OppCaricaPeer::ID);

		$rs = OppCaricaHasGruppoPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinAllExceptOppCarica(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OppCaricaHasGruppoPeer::addSelectColumns($c);
		$startcol2 = (OppCaricaHasGruppoPeer::NUM_COLUMNS - OppCaricaHasGruppoPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OppGruppoPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OppGruppoPeer::NUM_COLUMNS;

		$c->addJoin(OppCaricaHasGruppoPeer::GRUPPO_ID, OppGruppoPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppCaricaHasGruppoPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = OppGruppoPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getOppGruppo(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addOppCaricaHasGruppo($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initOppCaricaHasGruppos();
				$obj2->addOppCaricaHasGruppo($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptOppGruppo(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OppCaricaHasGruppoPeer::addSelectColumns($c);
		$startcol2 = (OppCaricaHasGruppoPeer::NUM_COLUMNS - OppCaricaHasGruppoPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OppCaricaPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OppCaricaPeer::NUM_COLUMNS;

		$c->addJoin(OppCaricaHasGruppoPeer::CARICA_ID, OppCaricaPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppCaricaHasGruppoPeer::getOMClass();

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
					$temp_obj2->addOppCaricaHasGruppo($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initOppCaricaHasGruppos();
				$obj2->addOppCaricaHasGruppo($obj1);
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
		return OppCaricaHasGruppoPeer::CLASS_DEFAULT;
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
			$comparison = $criteria->getComparison(OppCaricaHasGruppoPeer::CARICA_ID);
			$selectCriteria->add(OppCaricaHasGruppoPeer::CARICA_ID, $criteria->remove(OppCaricaHasGruppoPeer::CARICA_ID), $comparison);

			$comparison = $criteria->getComparison(OppCaricaHasGruppoPeer::GRUPPO_ID);
			$selectCriteria->add(OppCaricaHasGruppoPeer::GRUPPO_ID, $criteria->remove(OppCaricaHasGruppoPeer::GRUPPO_ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(OppCaricaHasGruppoPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(OppCaricaHasGruppoPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof OppCaricaHasGruppo) {

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

			$criteria->add(OppCaricaHasGruppoPeer::CARICA_ID, $vals[0], Criteria::IN);
			$criteria->add(OppCaricaHasGruppoPeer::GRUPPO_ID, $vals[1], Criteria::IN);
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

	
	public static function doValidate(OppCaricaHasGruppo $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(OppCaricaHasGruppoPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(OppCaricaHasGruppoPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(OppCaricaHasGruppoPeer::DATABASE_NAME, OppCaricaHasGruppoPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = OppCaricaHasGruppoPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
            $request->setError($col, $failed->getMessage());
        }
    }

    return $res;
	}

	
	public static function retrieveByPK( $carica_id, $gruppo_id, $con = null) {
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$criteria = new Criteria();
		$criteria->add(OppCaricaHasGruppoPeer::CARICA_ID, $carica_id);
		$criteria->add(OppCaricaHasGruppoPeer::GRUPPO_ID, $gruppo_id);
		$v = OppCaricaHasGruppoPeer::doSelect($criteria, $con);

		return !empty($v) ? $v[0] : null;
	}
} 
if (Propel::isInit()) {
			try {
		BaseOppCaricaHasGruppoPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/OppCaricaHasGruppoMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.OppCaricaHasGruppoMapBuilder');
}
