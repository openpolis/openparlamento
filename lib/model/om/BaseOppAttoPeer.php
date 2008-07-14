<?php


abstract class BaseOppAttoPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'opp_atto';

	
	const CLASS_DEFAULT = 'lib.model.OppAtto';

	
	const NUM_COLUMNS = 15;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'opp_atto.ID';

	
	const PARLAMENTO_ID = 'opp_atto.PARLAMENTO_ID';

	
	const TIPO_ATTO_ID = 'opp_atto.TIPO_ATTO_ID';

	
	const RAMO = 'opp_atto.RAMO';

	
	const NUMFASE = 'opp_atto.NUMFASE';

	
	const LEGISLATURA = 'opp_atto.LEGISLATURA';

	
	const DATA_PRES = 'opp_atto.DATA_PRES';

	
	const DATA_AGG = 'opp_atto.DATA_AGG';

	
	const TITOLO = 'opp_atto.TITOLO';

	
	const INIZIATIVA = 'opp_atto.INIZIATIVA';

	
	const COMPLETO = 'opp_atto.COMPLETO';

	
	const DESCRIZIONE = 'opp_atto.DESCRIZIONE';

	
	const SEDUTA = 'opp_atto.SEDUTA';

	
	const ITER = 'opp_atto.ITER';

	
	const DATA_ITER = 'opp_atto.DATA_ITER';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'ParlamentoId', 'TipoAttoId', 'Ramo', 'Numfase', 'Legislatura', 'DataPres', 'DataAgg', 'Titolo', 'Iniziativa', 'Completo', 'Descrizione', 'Seduta', 'Iter', 'DataIter', ),
		BasePeer::TYPE_COLNAME => array (OppAttoPeer::ID, OppAttoPeer::PARLAMENTO_ID, OppAttoPeer::TIPO_ATTO_ID, OppAttoPeer::RAMO, OppAttoPeer::NUMFASE, OppAttoPeer::LEGISLATURA, OppAttoPeer::DATA_PRES, OppAttoPeer::DATA_AGG, OppAttoPeer::TITOLO, OppAttoPeer::INIZIATIVA, OppAttoPeer::COMPLETO, OppAttoPeer::DESCRIZIONE, OppAttoPeer::SEDUTA, OppAttoPeer::ITER, OppAttoPeer::DATA_ITER, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'parlamento_id', 'tipo_atto_id', 'ramo', 'numfase', 'legislatura', 'data_pres', 'data_agg', 'titolo', 'iniziativa', 'completo', 'descrizione', 'seduta', 'iter', 'data_iter', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'ParlamentoId' => 1, 'TipoAttoId' => 2, 'Ramo' => 3, 'Numfase' => 4, 'Legislatura' => 5, 'DataPres' => 6, 'DataAgg' => 7, 'Titolo' => 8, 'Iniziativa' => 9, 'Completo' => 10, 'Descrizione' => 11, 'Seduta' => 12, 'Iter' => 13, 'DataIter' => 14, ),
		BasePeer::TYPE_COLNAME => array (OppAttoPeer::ID => 0, OppAttoPeer::PARLAMENTO_ID => 1, OppAttoPeer::TIPO_ATTO_ID => 2, OppAttoPeer::RAMO => 3, OppAttoPeer::NUMFASE => 4, OppAttoPeer::LEGISLATURA => 5, OppAttoPeer::DATA_PRES => 6, OppAttoPeer::DATA_AGG => 7, OppAttoPeer::TITOLO => 8, OppAttoPeer::INIZIATIVA => 9, OppAttoPeer::COMPLETO => 10, OppAttoPeer::DESCRIZIONE => 11, OppAttoPeer::SEDUTA => 12, OppAttoPeer::ITER => 13, OppAttoPeer::DATA_ITER => 14, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'parlamento_id' => 1, 'tipo_atto_id' => 2, 'ramo' => 3, 'numfase' => 4, 'legislatura' => 5, 'data_pres' => 6, 'data_agg' => 7, 'titolo' => 8, 'iniziativa' => 9, 'completo' => 10, 'descrizione' => 11, 'seduta' => 12, 'iter' => 13, 'data_iter' => 14, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/OppAttoMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.OppAttoMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = OppAttoPeer::getTableMap();
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
		return str_replace(OppAttoPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(OppAttoPeer::ID);

		$criteria->addSelectColumn(OppAttoPeer::PARLAMENTO_ID);

		$criteria->addSelectColumn(OppAttoPeer::TIPO_ATTO_ID);

		$criteria->addSelectColumn(OppAttoPeer::RAMO);

		$criteria->addSelectColumn(OppAttoPeer::NUMFASE);

		$criteria->addSelectColumn(OppAttoPeer::LEGISLATURA);

		$criteria->addSelectColumn(OppAttoPeer::DATA_PRES);

		$criteria->addSelectColumn(OppAttoPeer::DATA_AGG);

		$criteria->addSelectColumn(OppAttoPeer::TITOLO);

		$criteria->addSelectColumn(OppAttoPeer::INIZIATIVA);

		$criteria->addSelectColumn(OppAttoPeer::COMPLETO);

		$criteria->addSelectColumn(OppAttoPeer::DESCRIZIONE);

		$criteria->addSelectColumn(OppAttoPeer::SEDUTA);

		$criteria->addSelectColumn(OppAttoPeer::ITER);

		$criteria->addSelectColumn(OppAttoPeer::DATA_ITER);

	}

	const COUNT = 'COUNT(opp_atto.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT opp_atto.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppAttoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppAttoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = OppAttoPeer::doSelectRS($criteria, $con);
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
		$objects = OppAttoPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return OppAttoPeer::populateObjects(OppAttoPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			OppAttoPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = OppAttoPeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}

	
	public static function doCountJoinOppTipoAtto(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppAttoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppAttoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppAttoPeer::TIPO_ATTO_ID, OppTipoAttoPeer::ID);

		$rs = OppAttoPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinOppTipoAtto(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OppAttoPeer::addSelectColumns($c);
		$startcol = (OppAttoPeer::NUM_COLUMNS - OppAttoPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		OppTipoAttoPeer::addSelectColumns($c);

		$c->addJoin(OppAttoPeer::TIPO_ATTO_ID, OppTipoAttoPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppAttoPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = OppTipoAttoPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getOppTipoAtto(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addOppAtto($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initOppAttos();
				$obj2->addOppAtto($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppAttoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppAttoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppAttoPeer::TIPO_ATTO_ID, OppTipoAttoPeer::ID);

		$rs = OppAttoPeer::doSelectRS($criteria, $con);
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

		OppAttoPeer::addSelectColumns($c);
		$startcol2 = (OppAttoPeer::NUM_COLUMNS - OppAttoPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OppTipoAttoPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OppTipoAttoPeer::NUM_COLUMNS;

		$c->addJoin(OppAttoPeer::TIPO_ATTO_ID, OppTipoAttoPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppAttoPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


					
			$omClass = OppTipoAttoPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getOppTipoAtto(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addOppAtto($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initOppAttos();
				$obj2->addOppAtto($obj1);
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
		return OppAttoPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(OppAttoPeer::ID); 

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
			$comparison = $criteria->getComparison(OppAttoPeer::ID);
			$selectCriteria->add(OppAttoPeer::ID, $criteria->remove(OppAttoPeer::ID), $comparison);

			$comparison = $criteria->getComparison(OppAttoPeer::TIPO_ATTO_ID);
			$selectCriteria->add(OppAttoPeer::TIPO_ATTO_ID, $criteria->remove(OppAttoPeer::TIPO_ATTO_ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(OppAttoPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(OppAttoPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof OppAtto) {

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

			$criteria->add(OppAttoPeer::ID, $vals[0], Criteria::IN);
			$criteria->add(OppAttoPeer::TIPO_ATTO_ID, $vals[1], Criteria::IN);
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

	
	public static function doValidate(OppAtto $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(OppAttoPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(OppAttoPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(OppAttoPeer::DATABASE_NAME, OppAttoPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = OppAttoPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
            $request->setError($col, $failed->getMessage());
        }
    }

    return $res;
	}

	
	public static function retrieveByPK( $id, $tipo_atto_id, $con = null) {
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$criteria = new Criteria();
		$criteria->add(OppAttoPeer::ID, $id);
		$criteria->add(OppAttoPeer::TIPO_ATTO_ID, $tipo_atto_id);
		$v = OppAttoPeer::doSelect($criteria, $con);

		return !empty($v) ? $v[0] : null;
	}
} 
if (Propel::isInit()) {
			try {
		BaseOppAttoPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/OppAttoMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.OppAttoMapBuilder');
}
