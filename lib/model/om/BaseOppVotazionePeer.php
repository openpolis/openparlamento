<?php


abstract class BaseOppVotazionePeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'opp_votazione';

	
	const CLASS_DEFAULT = 'lib.model.OppVotazione';

	
	const NUM_COLUMNS = 17;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'opp_votazione.ID';

	
	const SEDUTA_ID = 'opp_votazione.SEDUTA_ID';

	
	const NUMERO_VOTAZIONE = 'opp_votazione.NUMERO_VOTAZIONE';

	
	const TITOLO = 'opp_votazione.TITOLO';

	
	const PRESENTI = 'opp_votazione.PRESENTI';

	
	const VOTANTI = 'opp_votazione.VOTANTI';

	
	const MAGGIORANZA = 'opp_votazione.MAGGIORANZA';

	
	const ASTENUTI = 'opp_votazione.ASTENUTI';

	
	const FAVOREVOLI = 'opp_votazione.FAVOREVOLI';

	
	const CONTRARI = 'opp_votazione.CONTRARI';

	
	const ESITO = 'opp_votazione.ESITO';

	
	const RIBELLI = 'opp_votazione.RIBELLI';

	
	const MARGINE = 'opp_votazione.MARGINE';

	
	const TIPOLOGIA = 'opp_votazione.TIPOLOGIA';

	
	const DESCRIZIONE = 'opp_votazione.DESCRIZIONE';

	
	const URL = 'opp_votazione.URL';

	
	const FINALE = 'opp_votazione.FINALE';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'SedutaId', 'NumeroVotazione', 'Titolo', 'Presenti', 'Votanti', 'Maggioranza', 'Astenuti', 'Favorevoli', 'Contrari', 'Esito', 'Ribelli', 'Margine', 'Tipologia', 'Descrizione', 'Url', 'Finale', ),
		BasePeer::TYPE_COLNAME => array (OppVotazionePeer::ID, OppVotazionePeer::SEDUTA_ID, OppVotazionePeer::NUMERO_VOTAZIONE, OppVotazionePeer::TITOLO, OppVotazionePeer::PRESENTI, OppVotazionePeer::VOTANTI, OppVotazionePeer::MAGGIORANZA, OppVotazionePeer::ASTENUTI, OppVotazionePeer::FAVOREVOLI, OppVotazionePeer::CONTRARI, OppVotazionePeer::ESITO, OppVotazionePeer::RIBELLI, OppVotazionePeer::MARGINE, OppVotazionePeer::TIPOLOGIA, OppVotazionePeer::DESCRIZIONE, OppVotazionePeer::URL, OppVotazionePeer::FINALE, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'seduta_id', 'numero_votazione', 'titolo', 'presenti', 'votanti', 'maggioranza', 'astenuti', 'favorevoli', 'contrari', 'esito', 'ribelli', 'margine', 'tipologia', 'descrizione', 'url', 'finale', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'SedutaId' => 1, 'NumeroVotazione' => 2, 'Titolo' => 3, 'Presenti' => 4, 'Votanti' => 5, 'Maggioranza' => 6, 'Astenuti' => 7, 'Favorevoli' => 8, 'Contrari' => 9, 'Esito' => 10, 'Ribelli' => 11, 'Margine' => 12, 'Tipologia' => 13, 'Descrizione' => 14, 'Url' => 15, 'Finale' => 16, ),
		BasePeer::TYPE_COLNAME => array (OppVotazionePeer::ID => 0, OppVotazionePeer::SEDUTA_ID => 1, OppVotazionePeer::NUMERO_VOTAZIONE => 2, OppVotazionePeer::TITOLO => 3, OppVotazionePeer::PRESENTI => 4, OppVotazionePeer::VOTANTI => 5, OppVotazionePeer::MAGGIORANZA => 6, OppVotazionePeer::ASTENUTI => 7, OppVotazionePeer::FAVOREVOLI => 8, OppVotazionePeer::CONTRARI => 9, OppVotazionePeer::ESITO => 10, OppVotazionePeer::RIBELLI => 11, OppVotazionePeer::MARGINE => 12, OppVotazionePeer::TIPOLOGIA => 13, OppVotazionePeer::DESCRIZIONE => 14, OppVotazionePeer::URL => 15, OppVotazionePeer::FINALE => 16, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'seduta_id' => 1, 'numero_votazione' => 2, 'titolo' => 3, 'presenti' => 4, 'votanti' => 5, 'maggioranza' => 6, 'astenuti' => 7, 'favorevoli' => 8, 'contrari' => 9, 'esito' => 10, 'ribelli' => 11, 'margine' => 12, 'tipologia' => 13, 'descrizione' => 14, 'url' => 15, 'finale' => 16, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/OppVotazioneMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.OppVotazioneMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = OppVotazionePeer::getTableMap();
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
		return str_replace(OppVotazionePeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(OppVotazionePeer::ID);

		$criteria->addSelectColumn(OppVotazionePeer::SEDUTA_ID);

		$criteria->addSelectColumn(OppVotazionePeer::NUMERO_VOTAZIONE);

		$criteria->addSelectColumn(OppVotazionePeer::TITOLO);

		$criteria->addSelectColumn(OppVotazionePeer::PRESENTI);

		$criteria->addSelectColumn(OppVotazionePeer::VOTANTI);

		$criteria->addSelectColumn(OppVotazionePeer::MAGGIORANZA);

		$criteria->addSelectColumn(OppVotazionePeer::ASTENUTI);

		$criteria->addSelectColumn(OppVotazionePeer::FAVOREVOLI);

		$criteria->addSelectColumn(OppVotazionePeer::CONTRARI);

		$criteria->addSelectColumn(OppVotazionePeer::ESITO);

		$criteria->addSelectColumn(OppVotazionePeer::RIBELLI);

		$criteria->addSelectColumn(OppVotazionePeer::MARGINE);

		$criteria->addSelectColumn(OppVotazionePeer::TIPOLOGIA);

		$criteria->addSelectColumn(OppVotazionePeer::DESCRIZIONE);

		$criteria->addSelectColumn(OppVotazionePeer::URL);

		$criteria->addSelectColumn(OppVotazionePeer::FINALE);

	}

	const COUNT = 'COUNT(opp_votazione.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT opp_votazione.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppVotazionePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppVotazionePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = OppVotazionePeer::doSelectRS($criteria, $con);
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
		$objects = OppVotazionePeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return OppVotazionePeer::populateObjects(OppVotazionePeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			OppVotazionePeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = OppVotazionePeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}

	
	public static function doCountJoinOppSeduta(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppVotazionePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppVotazionePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppVotazionePeer::SEDUTA_ID, OppSedutaPeer::ID);

		$rs = OppVotazionePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinOppSeduta(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OppVotazionePeer::addSelectColumns($c);
		$startcol = (OppVotazionePeer::NUM_COLUMNS - OppVotazionePeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		OppSedutaPeer::addSelectColumns($c);

		$c->addJoin(OppVotazionePeer::SEDUTA_ID, OppSedutaPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppVotazionePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = OppSedutaPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getOppSeduta(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addOppVotazione($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initOppVotaziones();
				$obj2->addOppVotazione($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppVotazionePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppVotazionePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppVotazionePeer::SEDUTA_ID, OppSedutaPeer::ID);

		$rs = OppVotazionePeer::doSelectRS($criteria, $con);
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

		OppVotazionePeer::addSelectColumns($c);
		$startcol2 = (OppVotazionePeer::NUM_COLUMNS - OppVotazionePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OppSedutaPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OppSedutaPeer::NUM_COLUMNS;

		$c->addJoin(OppVotazionePeer::SEDUTA_ID, OppSedutaPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppVotazionePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


					
			$omClass = OppSedutaPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getOppSeduta(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addOppVotazione($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initOppVotaziones();
				$obj2->addOppVotazione($obj1);
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
		return OppVotazionePeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(OppVotazionePeer::ID); 

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
			$comparison = $criteria->getComparison(OppVotazionePeer::ID);
			$selectCriteria->add(OppVotazionePeer::ID, $criteria->remove(OppVotazionePeer::ID), $comparison);

			$comparison = $criteria->getComparison(OppVotazionePeer::SEDUTA_ID);
			$selectCriteria->add(OppVotazionePeer::SEDUTA_ID, $criteria->remove(OppVotazionePeer::SEDUTA_ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(OppVotazionePeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(OppVotazionePeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof OppVotazione) {

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

			$criteria->add(OppVotazionePeer::ID, $vals[0], Criteria::IN);
			$criteria->add(OppVotazionePeer::SEDUTA_ID, $vals[1], Criteria::IN);
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

	
	public static function doValidate(OppVotazione $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(OppVotazionePeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(OppVotazionePeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(OppVotazionePeer::DATABASE_NAME, OppVotazionePeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = OppVotazionePeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
            $request->setError($col, $failed->getMessage());
        }
    }

    return $res;
	}

	
	public static function retrieveByPK( $id, $seduta_id, $con = null) {
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$criteria = new Criteria();
		$criteria->add(OppVotazionePeer::ID, $id);
		$criteria->add(OppVotazionePeer::SEDUTA_ID, $seduta_id);
		$v = OppVotazionePeer::doSelect($criteria, $con);

		return !empty($v) ? $v[0] : null;
	}
} 
if (Propel::isInit()) {
			try {
		BaseOppVotazionePeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/OppVotazioneMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.OppVotazioneMapBuilder');
}
