<?php


abstract class BaseOppDdlPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'opp_ddl';

	
	const CLASS_DEFAULT = 'lib.model.OppDdl';

	
	const NUM_COLUMNS = 15;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'opp_ddl.ID';

	
	const PARLAMENTO_ID = 'opp_ddl.PARLAMENTO_ID';

	
	const TIPO = 'opp_ddl.TIPO';

	
	const RAMO = 'opp_ddl.RAMO';

	
	const NUMFASE = 'opp_ddl.NUMFASE';

	
	const LEGISLATURA = 'opp_ddl.LEGISLATURA';

	
	const DATA_PRES = 'opp_ddl.DATA_PRES';

	
	const DATA_AGG = 'opp_ddl.DATA_AGG';

	
	const TITOLO = 'opp_ddl.TITOLO';

	
	const INIZIATIVA = 'opp_ddl.INIZIATIVA';

	
	const COMPLETO = 'opp_ddl.COMPLETO';

	
	const DESCRIZIONE = 'opp_ddl.DESCRIZIONE';

	
	const SEDUTA = 'opp_ddl.SEDUTA';

	
	const ITER = 'opp_ddl.ITER';

	
	const DATA_ITER = 'opp_ddl.DATA_ITER';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'ParlamentoId', 'Tipo', 'Ramo', 'Numfase', 'Legislatura', 'DataPres', 'DataAgg', 'Titolo', 'Iniziativa', 'Completo', 'Descrizione', 'Seduta', 'Iter', 'DataIter', ),
		BasePeer::TYPE_COLNAME => array (OppDdlPeer::ID, OppDdlPeer::PARLAMENTO_ID, OppDdlPeer::TIPO, OppDdlPeer::RAMO, OppDdlPeer::NUMFASE, OppDdlPeer::LEGISLATURA, OppDdlPeer::DATA_PRES, OppDdlPeer::DATA_AGG, OppDdlPeer::TITOLO, OppDdlPeer::INIZIATIVA, OppDdlPeer::COMPLETO, OppDdlPeer::DESCRIZIONE, OppDdlPeer::SEDUTA, OppDdlPeer::ITER, OppDdlPeer::DATA_ITER, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'parlamento_id', 'tipo', 'ramo', 'numfase', 'legislatura', 'data_pres', 'data_agg', 'titolo', 'iniziativa', 'completo', 'descrizione', 'seduta', 'iter', 'data_iter', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'ParlamentoId' => 1, 'Tipo' => 2, 'Ramo' => 3, 'Numfase' => 4, 'Legislatura' => 5, 'DataPres' => 6, 'DataAgg' => 7, 'Titolo' => 8, 'Iniziativa' => 9, 'Completo' => 10, 'Descrizione' => 11, 'Seduta' => 12, 'Iter' => 13, 'DataIter' => 14, ),
		BasePeer::TYPE_COLNAME => array (OppDdlPeer::ID => 0, OppDdlPeer::PARLAMENTO_ID => 1, OppDdlPeer::TIPO => 2, OppDdlPeer::RAMO => 3, OppDdlPeer::NUMFASE => 4, OppDdlPeer::LEGISLATURA => 5, OppDdlPeer::DATA_PRES => 6, OppDdlPeer::DATA_AGG => 7, OppDdlPeer::TITOLO => 8, OppDdlPeer::INIZIATIVA => 9, OppDdlPeer::COMPLETO => 10, OppDdlPeer::DESCRIZIONE => 11, OppDdlPeer::SEDUTA => 12, OppDdlPeer::ITER => 13, OppDdlPeer::DATA_ITER => 14, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'parlamento_id' => 1, 'tipo' => 2, 'ramo' => 3, 'numfase' => 4, 'legislatura' => 5, 'data_pres' => 6, 'data_agg' => 7, 'titolo' => 8, 'iniziativa' => 9, 'completo' => 10, 'descrizione' => 11, 'seduta' => 12, 'iter' => 13, 'data_iter' => 14, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/OppDdlMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.OppDdlMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = OppDdlPeer::getTableMap();
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
		return str_replace(OppDdlPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(OppDdlPeer::ID);

		$criteria->addSelectColumn(OppDdlPeer::PARLAMENTO_ID);

		$criteria->addSelectColumn(OppDdlPeer::TIPO);

		$criteria->addSelectColumn(OppDdlPeer::RAMO);

		$criteria->addSelectColumn(OppDdlPeer::NUMFASE);

		$criteria->addSelectColumn(OppDdlPeer::LEGISLATURA);

		$criteria->addSelectColumn(OppDdlPeer::DATA_PRES);

		$criteria->addSelectColumn(OppDdlPeer::DATA_AGG);

		$criteria->addSelectColumn(OppDdlPeer::TITOLO);

		$criteria->addSelectColumn(OppDdlPeer::INIZIATIVA);

		$criteria->addSelectColumn(OppDdlPeer::COMPLETO);

		$criteria->addSelectColumn(OppDdlPeer::DESCRIZIONE);

		$criteria->addSelectColumn(OppDdlPeer::SEDUTA);

		$criteria->addSelectColumn(OppDdlPeer::ITER);

		$criteria->addSelectColumn(OppDdlPeer::DATA_ITER);

	}

	const COUNT = 'COUNT(opp_ddl.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT opp_ddl.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppDdlPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppDdlPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = OppDdlPeer::doSelectRS($criteria, $con);
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
		$objects = OppDdlPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return OppDdlPeer::populateObjects(OppDdlPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			OppDdlPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = OppDdlPeer::getOMClass();
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
		return OppDdlPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(OppDdlPeer::ID); 

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
			$comparison = $criteria->getComparison(OppDdlPeer::ID);
			$selectCriteria->add(OppDdlPeer::ID, $criteria->remove(OppDdlPeer::ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(OppDdlPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(OppDdlPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof OppDdl) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(OppDdlPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(OppDdl $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(OppDdlPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(OppDdlPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(OppDdlPeer::DATABASE_NAME, OppDdlPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = OppDdlPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(OppDdlPeer::DATABASE_NAME);

		$criteria->add(OppDdlPeer::ID, $pk);


		$v = OppDdlPeer::doSelect($criteria, $con);

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
			$criteria->add(OppDdlPeer::ID, $pks, Criteria::IN);
			$objs = OppDdlPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseOppDdlPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/OppDdlMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.OppDdlMapBuilder');
}
