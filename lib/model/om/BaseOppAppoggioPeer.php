<?php


abstract class BaseOppAppoggioPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'opp_appoggio';

	
	const CLASS_DEFAULT = 'lib.model.OppAppoggio';

	
	const NUM_COLUMNS = 5;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'opp_appoggio.ID';

	
	const CARICA_ID = 'opp_appoggio.CARICA_ID';

	
	const AKA = 'opp_appoggio.AKA';

	
	const TIPOLOGIA = 'opp_appoggio.TIPOLOGIA';

	
	const LEGISLATURA = 'opp_appoggio.LEGISLATURA';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'CaricaId', 'Aka', 'Tipologia', 'Legislatura', ),
		BasePeer::TYPE_COLNAME => array (OppAppoggioPeer::ID, OppAppoggioPeer::CARICA_ID, OppAppoggioPeer::AKA, OppAppoggioPeer::TIPOLOGIA, OppAppoggioPeer::LEGISLATURA, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'carica_id', 'aka', 'tipologia', 'legislatura', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'CaricaId' => 1, 'Aka' => 2, 'Tipologia' => 3, 'Legislatura' => 4, ),
		BasePeer::TYPE_COLNAME => array (OppAppoggioPeer::ID => 0, OppAppoggioPeer::CARICA_ID => 1, OppAppoggioPeer::AKA => 2, OppAppoggioPeer::TIPOLOGIA => 3, OppAppoggioPeer::LEGISLATURA => 4, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'carica_id' => 1, 'aka' => 2, 'tipologia' => 3, 'legislatura' => 4, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/OppAppoggioMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.OppAppoggioMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = OppAppoggioPeer::getTableMap();
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
		return str_replace(OppAppoggioPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(OppAppoggioPeer::ID);

		$criteria->addSelectColumn(OppAppoggioPeer::CARICA_ID);

		$criteria->addSelectColumn(OppAppoggioPeer::AKA);

		$criteria->addSelectColumn(OppAppoggioPeer::TIPOLOGIA);

		$criteria->addSelectColumn(OppAppoggioPeer::LEGISLATURA);

	}

	const COUNT = 'COUNT(opp_appoggio.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT opp_appoggio.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppAppoggioPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppAppoggioPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = OppAppoggioPeer::doSelectRS($criteria, $con);
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
		$objects = OppAppoggioPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return OppAppoggioPeer::populateObjects(OppAppoggioPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			OppAppoggioPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = OppAppoggioPeer::getOMClass();
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
			$criteria->addSelectColumn(OppAppoggioPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppAppoggioPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppAppoggioPeer::CARICA_ID, OppCaricaPeer::ID);

		$rs = OppAppoggioPeer::doSelectRS($criteria, $con);
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

		OppAppoggioPeer::addSelectColumns($c);
		$startcol = (OppAppoggioPeer::NUM_COLUMNS - OppAppoggioPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		OppCaricaPeer::addSelectColumns($c);

		$c->addJoin(OppAppoggioPeer::CARICA_ID, OppCaricaPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppAppoggioPeer::getOMClass();

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
										$temp_obj2->addOppAppoggio($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initOppAppoggios();
				$obj2->addOppAppoggio($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppAppoggioPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppAppoggioPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppAppoggioPeer::CARICA_ID, OppCaricaPeer::ID);

		$rs = OppAppoggioPeer::doSelectRS($criteria, $con);
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

		OppAppoggioPeer::addSelectColumns($c);
		$startcol2 = (OppAppoggioPeer::NUM_COLUMNS - OppAppoggioPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OppCaricaPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OppCaricaPeer::NUM_COLUMNS;

		$c->addJoin(OppAppoggioPeer::CARICA_ID, OppCaricaPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppAppoggioPeer::getOMClass();


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
					$temp_obj2->addOppAppoggio($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initOppAppoggios();
				$obj2->addOppAppoggio($obj1);
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
		return OppAppoggioPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(OppAppoggioPeer::ID); 

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
			$comparison = $criteria->getComparison(OppAppoggioPeer::ID);
			$selectCriteria->add(OppAppoggioPeer::ID, $criteria->remove(OppAppoggioPeer::ID), $comparison);

			$comparison = $criteria->getComparison(OppAppoggioPeer::CARICA_ID);
			$selectCriteria->add(OppAppoggioPeer::CARICA_ID, $criteria->remove(OppAppoggioPeer::CARICA_ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(OppAppoggioPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(OppAppoggioPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof OppAppoggio) {

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

			$criteria->add(OppAppoggioPeer::ID, $vals[0], Criteria::IN);
			$criteria->add(OppAppoggioPeer::CARICA_ID, $vals[1], Criteria::IN);
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

	
	public static function doValidate(OppAppoggio $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(OppAppoggioPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(OppAppoggioPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(OppAppoggioPeer::DATABASE_NAME, OppAppoggioPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = OppAppoggioPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
            $request->setError($col, $failed->getMessage());
        }
    }

    return $res;
	}

	
	public static function retrieveByPK( $id, $carica_id, $con = null) {
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$criteria = new Criteria();
		$criteria->add(OppAppoggioPeer::ID, $id);
		$criteria->add(OppAppoggioPeer::CARICA_ID, $carica_id);
		$v = OppAppoggioPeer::doSelect($criteria, $con);

		return !empty($v) ? $v[0] : null;
	}
} 
if (Propel::isInit()) {
			try {
		BaseOppAppoggioPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/OppAppoggioMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.OppAppoggioMapBuilder');
}
