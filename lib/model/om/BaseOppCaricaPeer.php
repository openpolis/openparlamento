<?php


abstract class BaseOppCaricaPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'opp_carica';

	
	const CLASS_DEFAULT = 'lib.model.OppCarica';

	
	const NUM_COLUMNS = 36;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'opp_carica.ID';

	
	const POLITICO_ID = 'opp_carica.POLITICO_ID';

	
	const CARICA = 'opp_carica.CARICA';

	
	const DATA_INIZIO = 'opp_carica.DATA_INIZIO';

	
	const DATA_FINE = 'opp_carica.DATA_FINE';

	
	const LEGISLATURA = 'opp_carica.LEGISLATURA';

	
	const CIRCOSCRIZIONE = 'opp_carica.CIRCOSCRIZIONE';

	
	const PRESENZE = 'opp_carica.PRESENZE';

	
	const ASSENZE = 'opp_carica.ASSENZE';

	
	const MISSIONI = 'opp_carica.MISSIONI';

	
	const PARLIAMENT_ID = 'opp_carica.PARLIAMENT_ID';

	
	const PDL_1 = 'opp_carica.PDL_1';

	
	const PDL_2 = 'opp_carica.PDL_2';

	
	const MOZIONE_1 = 'opp_carica.MOZIONE_1';

	
	const MOZIONE_DI_FIDUCIA_1 = 'opp_carica.MOZIONE_DI_FIDUCIA_1';

	
	const MOZIONE_EX_ART138_COMMA_2_1 = 'opp_carica.MOZIONE_EX_ART138_COMMA_2_1';

	
	const INTERPELLANZA_1 = 'opp_carica.INTERPELLANZA_1';

	
	const INTERPELLANZA_URGENTE_1 = 'opp_carica.INTERPELLANZA_URGENTE_1';

	
	const INTERROGAZIONE_A_RISPOSTA_IMMEDIATA_IN_ASSEMBLEA_1 = 'opp_carica.INTERROGAZIONE_A_RISPOSTA_IMMEDIATA_IN_ASSEMBLEA_1';

	
	const INTERROGAZIONE_A_RISPOSTA_ORALE_1 = 'opp_carica.INTERROGAZIONE_A_RISPOSTA_ORALE_1';

	
	const INTERROGAZIONE_A_RISPOSTA_SCRITTA_1 = 'opp_carica.INTERROGAZIONE_A_RISPOSTA_SCRITTA_1';

	
	const INTERROGAZIONE_A_RISPOSTA_IMMEDIATA_IN_COMMISSIONE_1 = 'opp_carica.INTERROGAZIONE_A_RISPOSTA_IMMEDIATA_IN_COMMISSIONE_1';

	
	const INTERROGAZIONE_A_RISPOSTA_IN_COMMISSIONE_1 = 'opp_carica.INTERROGAZIONE_A_RISPOSTA_IN_COMMISSIONE_1';

	
	const RISOLUZIONE_IN_ASSEMBLEA_1 = 'opp_carica.RISOLUZIONE_IN_ASSEMBLEA_1';

	
	const RISOLUZIONE_IN_COMMISSIONE_1 = 'opp_carica.RISOLUZIONE_IN_COMMISSIONE_1';

	
	const RISOLUZIONE_IN_COMMISSIONE_CONCLUSIVA_DI_DIBATTITO_1 = 'opp_carica.RISOLUZIONE_IN_COMMISSIONE_CONCLUSIVA_DI_DIBATTITO_1';

	
	const ODG_IN_ASSEMBLEA_SU_BILANCIO_INTERNO_1 = 'opp_carica.ODG_IN_ASSEMBLEA_SU_BILANCIO_INTERNO_1';

	
	const ODG_IN_ASSEMBLEA_SU_MOZIONI_O_ALTRI_ATTI_1 = 'opp_carica.ODG_IN_ASSEMBLEA_SU_MOZIONI_O_ALTRI_ATTI_1';

	
	const ODG_IN_ASSEMBLEA_SU_PDL_1 = 'opp_carica.ODG_IN_ASSEMBLEA_SU_PDL_1';

	
	const ODG_IN_ASSEMBLEA_SU_PDL_DI_BILANCIO_1 = 'opp_carica.ODG_IN_ASSEMBLEA_SU_PDL_DI_BILANCIO_1';

	
	const ODG_IN_COMMISSIONE_1 = 'opp_carica.ODG_IN_COMMISSIONE_1';

	
	const ODG_SU_PDL_DI_BILANCIO_IN_COMMISSIONE_1 = 'opp_carica.ODG_SU_PDL_DI_BILANCIO_IN_COMMISSIONE_1';

	
	const INDICE = 'opp_carica.INDICE';

	
	const SCAGLIONE = 'opp_carica.SCAGLIONE';

	
	const POSIZIONE = 'opp_carica.POSIZIONE';

	
	const MEDIA = 'opp_carica.MEDIA';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'PoliticoId', 'Carica', 'DataInizio', 'DataFine', 'Legislatura', 'Circoscrizione', 'Presenze', 'Assenze', 'Missioni', 'ParliamentId', 'Pdl1', 'Pdl2', 'Mozione1', 'MozioneDiFiducia1', 'MozioneExArt138Comma21', 'Interpellanza1', 'InterpellanzaUrgente1', 'InterrogazioneARispostaImmediataInAssemblea1', 'InterrogazioneARispostaOrale1', 'InterrogazioneARispostaScritta1', 'InterrogazioneARispostaImmediataInCommissione1', 'InterrogazioneARispostaInCommissione1', 'RisoluzioneInAssemblea1', 'RisoluzioneInCommissione1', 'RisoluzioneInCommissioneConclusivaDiDibattito1', 'OdgInAssembleaSuBilancioInterno1', 'OdgInAssembleaSuMozioniOAltriAtti1', 'OdgInAssembleaSuPdl1', 'OdgInAssembleaSuPdlDiBilancio1', 'OdgInCommissione1', 'OdgSuPdlDiBilancioInCommissione1', 'Indice', 'Scaglione', 'Posizione', 'Media', ),
		BasePeer::TYPE_COLNAME => array (OppCaricaPeer::ID, OppCaricaPeer::POLITICO_ID, OppCaricaPeer::CARICA, OppCaricaPeer::DATA_INIZIO, OppCaricaPeer::DATA_FINE, OppCaricaPeer::LEGISLATURA, OppCaricaPeer::CIRCOSCRIZIONE, OppCaricaPeer::PRESENZE, OppCaricaPeer::ASSENZE, OppCaricaPeer::MISSIONI, OppCaricaPeer::PARLIAMENT_ID, OppCaricaPeer::PDL_1, OppCaricaPeer::PDL_2, OppCaricaPeer::MOZIONE_1, OppCaricaPeer::MOZIONE_DI_FIDUCIA_1, OppCaricaPeer::MOZIONE_EX_ART138_COMMA_2_1, OppCaricaPeer::INTERPELLANZA_1, OppCaricaPeer::INTERPELLANZA_URGENTE_1, OppCaricaPeer::INTERROGAZIONE_A_RISPOSTA_IMMEDIATA_IN_ASSEMBLEA_1, OppCaricaPeer::INTERROGAZIONE_A_RISPOSTA_ORALE_1, OppCaricaPeer::INTERROGAZIONE_A_RISPOSTA_SCRITTA_1, OppCaricaPeer::INTERROGAZIONE_A_RISPOSTA_IMMEDIATA_IN_COMMISSIONE_1, OppCaricaPeer::INTERROGAZIONE_A_RISPOSTA_IN_COMMISSIONE_1, OppCaricaPeer::RISOLUZIONE_IN_ASSEMBLEA_1, OppCaricaPeer::RISOLUZIONE_IN_COMMISSIONE_1, OppCaricaPeer::RISOLUZIONE_IN_COMMISSIONE_CONCLUSIVA_DI_DIBATTITO_1, OppCaricaPeer::ODG_IN_ASSEMBLEA_SU_BILANCIO_INTERNO_1, OppCaricaPeer::ODG_IN_ASSEMBLEA_SU_MOZIONI_O_ALTRI_ATTI_1, OppCaricaPeer::ODG_IN_ASSEMBLEA_SU_PDL_1, OppCaricaPeer::ODG_IN_ASSEMBLEA_SU_PDL_DI_BILANCIO_1, OppCaricaPeer::ODG_IN_COMMISSIONE_1, OppCaricaPeer::ODG_SU_PDL_DI_BILANCIO_IN_COMMISSIONE_1, OppCaricaPeer::INDICE, OppCaricaPeer::SCAGLIONE, OppCaricaPeer::POSIZIONE, OppCaricaPeer::MEDIA, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'politico_id', 'carica', 'data_inizio', 'data_fine', 'legislatura', 'circoscrizione', 'presenze', 'assenze', 'missioni', 'parliament_id', 'pdl_1', 'pdl_2', 'mozione_1', 'mozione_di_fiducia_1', 'mozione_ex_art138_comma_2_1', 'interpellanza_1', 'interpellanza_urgente_1', 'interrogazione_a_risposta_immediata_in_assemblea_1', 'interrogazione_a_risposta_orale_1', 'interrogazione_a_risposta_scritta_1', 'interrogazione_a_risposta_immediata_in_commissione_1', 'interrogazione_a_risposta_in_commissione_1', 'risoluzione_in_assemblea_1', 'risoluzione_in_commissione_1', 'risoluzione_in_commissione_conclusiva_di_dibattito_1', 'odg_in_assemblea_su_bilancio_interno_1', 'odg_in_assemblea_su_mozioni_o_altri_atti_1', 'odg_in_assemblea_su_pdl_1', 'odg_in_assemblea_su_pdl_di_bilancio_1', 'odg_in_commissione_1', 'odg_su_pdl_di_bilancio_in_commissione_1', 'indice', 'scaglione', 'posizione', 'media', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'PoliticoId' => 1, 'Carica' => 2, 'DataInizio' => 3, 'DataFine' => 4, 'Legislatura' => 5, 'Circoscrizione' => 6, 'Presenze' => 7, 'Assenze' => 8, 'Missioni' => 9, 'ParliamentId' => 10, 'Pdl1' => 11, 'Pdl2' => 12, 'Mozione1' => 13, 'MozioneDiFiducia1' => 14, 'MozioneExArt138Comma21' => 15, 'Interpellanza1' => 16, 'InterpellanzaUrgente1' => 17, 'InterrogazioneARispostaImmediataInAssemblea1' => 18, 'InterrogazioneARispostaOrale1' => 19, 'InterrogazioneARispostaScritta1' => 20, 'InterrogazioneARispostaImmediataInCommissione1' => 21, 'InterrogazioneARispostaInCommissione1' => 22, 'RisoluzioneInAssemblea1' => 23, 'RisoluzioneInCommissione1' => 24, 'RisoluzioneInCommissioneConclusivaDiDibattito1' => 25, 'OdgInAssembleaSuBilancioInterno1' => 26, 'OdgInAssembleaSuMozioniOAltriAtti1' => 27, 'OdgInAssembleaSuPdl1' => 28, 'OdgInAssembleaSuPdlDiBilancio1' => 29, 'OdgInCommissione1' => 30, 'OdgSuPdlDiBilancioInCommissione1' => 31, 'Indice' => 32, 'Scaglione' => 33, 'Posizione' => 34, 'Media' => 35, ),
		BasePeer::TYPE_COLNAME => array (OppCaricaPeer::ID => 0, OppCaricaPeer::POLITICO_ID => 1, OppCaricaPeer::CARICA => 2, OppCaricaPeer::DATA_INIZIO => 3, OppCaricaPeer::DATA_FINE => 4, OppCaricaPeer::LEGISLATURA => 5, OppCaricaPeer::CIRCOSCRIZIONE => 6, OppCaricaPeer::PRESENZE => 7, OppCaricaPeer::ASSENZE => 8, OppCaricaPeer::MISSIONI => 9, OppCaricaPeer::PARLIAMENT_ID => 10, OppCaricaPeer::PDL_1 => 11, OppCaricaPeer::PDL_2 => 12, OppCaricaPeer::MOZIONE_1 => 13, OppCaricaPeer::MOZIONE_DI_FIDUCIA_1 => 14, OppCaricaPeer::MOZIONE_EX_ART138_COMMA_2_1 => 15, OppCaricaPeer::INTERPELLANZA_1 => 16, OppCaricaPeer::INTERPELLANZA_URGENTE_1 => 17, OppCaricaPeer::INTERROGAZIONE_A_RISPOSTA_IMMEDIATA_IN_ASSEMBLEA_1 => 18, OppCaricaPeer::INTERROGAZIONE_A_RISPOSTA_ORALE_1 => 19, OppCaricaPeer::INTERROGAZIONE_A_RISPOSTA_SCRITTA_1 => 20, OppCaricaPeer::INTERROGAZIONE_A_RISPOSTA_IMMEDIATA_IN_COMMISSIONE_1 => 21, OppCaricaPeer::INTERROGAZIONE_A_RISPOSTA_IN_COMMISSIONE_1 => 22, OppCaricaPeer::RISOLUZIONE_IN_ASSEMBLEA_1 => 23, OppCaricaPeer::RISOLUZIONE_IN_COMMISSIONE_1 => 24, OppCaricaPeer::RISOLUZIONE_IN_COMMISSIONE_CONCLUSIVA_DI_DIBATTITO_1 => 25, OppCaricaPeer::ODG_IN_ASSEMBLEA_SU_BILANCIO_INTERNO_1 => 26, OppCaricaPeer::ODG_IN_ASSEMBLEA_SU_MOZIONI_O_ALTRI_ATTI_1 => 27, OppCaricaPeer::ODG_IN_ASSEMBLEA_SU_PDL_1 => 28, OppCaricaPeer::ODG_IN_ASSEMBLEA_SU_PDL_DI_BILANCIO_1 => 29, OppCaricaPeer::ODG_IN_COMMISSIONE_1 => 30, OppCaricaPeer::ODG_SU_PDL_DI_BILANCIO_IN_COMMISSIONE_1 => 31, OppCaricaPeer::INDICE => 32, OppCaricaPeer::SCAGLIONE => 33, OppCaricaPeer::POSIZIONE => 34, OppCaricaPeer::MEDIA => 35, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'politico_id' => 1, 'carica' => 2, 'data_inizio' => 3, 'data_fine' => 4, 'legislatura' => 5, 'circoscrizione' => 6, 'presenze' => 7, 'assenze' => 8, 'missioni' => 9, 'parliament_id' => 10, 'pdl_1' => 11, 'pdl_2' => 12, 'mozione_1' => 13, 'mozione_di_fiducia_1' => 14, 'mozione_ex_art138_comma_2_1' => 15, 'interpellanza_1' => 16, 'interpellanza_urgente_1' => 17, 'interrogazione_a_risposta_immediata_in_assemblea_1' => 18, 'interrogazione_a_risposta_orale_1' => 19, 'interrogazione_a_risposta_scritta_1' => 20, 'interrogazione_a_risposta_immediata_in_commissione_1' => 21, 'interrogazione_a_risposta_in_commissione_1' => 22, 'risoluzione_in_assemblea_1' => 23, 'risoluzione_in_commissione_1' => 24, 'risoluzione_in_commissione_conclusiva_di_dibattito_1' => 25, 'odg_in_assemblea_su_bilancio_interno_1' => 26, 'odg_in_assemblea_su_mozioni_o_altri_atti_1' => 27, 'odg_in_assemblea_su_pdl_1' => 28, 'odg_in_assemblea_su_pdl_di_bilancio_1' => 29, 'odg_in_commissione_1' => 30, 'odg_su_pdl_di_bilancio_in_commissione_1' => 31, 'indice' => 32, 'scaglione' => 33, 'posizione' => 34, 'media' => 35, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/OppCaricaMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.OppCaricaMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = OppCaricaPeer::getTableMap();
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
		return str_replace(OppCaricaPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(OppCaricaPeer::ID);

		$criteria->addSelectColumn(OppCaricaPeer::POLITICO_ID);

		$criteria->addSelectColumn(OppCaricaPeer::CARICA);

		$criteria->addSelectColumn(OppCaricaPeer::DATA_INIZIO);

		$criteria->addSelectColumn(OppCaricaPeer::DATA_FINE);

		$criteria->addSelectColumn(OppCaricaPeer::LEGISLATURA);

		$criteria->addSelectColumn(OppCaricaPeer::CIRCOSCRIZIONE);

		$criteria->addSelectColumn(OppCaricaPeer::PRESENZE);

		$criteria->addSelectColumn(OppCaricaPeer::ASSENZE);

		$criteria->addSelectColumn(OppCaricaPeer::MISSIONI);

		$criteria->addSelectColumn(OppCaricaPeer::PARLIAMENT_ID);

		$criteria->addSelectColumn(OppCaricaPeer::PDL_1);

		$criteria->addSelectColumn(OppCaricaPeer::PDL_2);

		$criteria->addSelectColumn(OppCaricaPeer::MOZIONE_1);

		$criteria->addSelectColumn(OppCaricaPeer::MOZIONE_DI_FIDUCIA_1);

		$criteria->addSelectColumn(OppCaricaPeer::MOZIONE_EX_ART138_COMMA_2_1);

		$criteria->addSelectColumn(OppCaricaPeer::INTERPELLANZA_1);

		$criteria->addSelectColumn(OppCaricaPeer::INTERPELLANZA_URGENTE_1);

		$criteria->addSelectColumn(OppCaricaPeer::INTERROGAZIONE_A_RISPOSTA_IMMEDIATA_IN_ASSEMBLEA_1);

		$criteria->addSelectColumn(OppCaricaPeer::INTERROGAZIONE_A_RISPOSTA_ORALE_1);

		$criteria->addSelectColumn(OppCaricaPeer::INTERROGAZIONE_A_RISPOSTA_SCRITTA_1);

		$criteria->addSelectColumn(OppCaricaPeer::INTERROGAZIONE_A_RISPOSTA_IMMEDIATA_IN_COMMISSIONE_1);

		$criteria->addSelectColumn(OppCaricaPeer::INTERROGAZIONE_A_RISPOSTA_IN_COMMISSIONE_1);

		$criteria->addSelectColumn(OppCaricaPeer::RISOLUZIONE_IN_ASSEMBLEA_1);

		$criteria->addSelectColumn(OppCaricaPeer::RISOLUZIONE_IN_COMMISSIONE_1);

		$criteria->addSelectColumn(OppCaricaPeer::RISOLUZIONE_IN_COMMISSIONE_CONCLUSIVA_DI_DIBATTITO_1);

		$criteria->addSelectColumn(OppCaricaPeer::ODG_IN_ASSEMBLEA_SU_BILANCIO_INTERNO_1);

		$criteria->addSelectColumn(OppCaricaPeer::ODG_IN_ASSEMBLEA_SU_MOZIONI_O_ALTRI_ATTI_1);

		$criteria->addSelectColumn(OppCaricaPeer::ODG_IN_ASSEMBLEA_SU_PDL_1);

		$criteria->addSelectColumn(OppCaricaPeer::ODG_IN_ASSEMBLEA_SU_PDL_DI_BILANCIO_1);

		$criteria->addSelectColumn(OppCaricaPeer::ODG_IN_COMMISSIONE_1);

		$criteria->addSelectColumn(OppCaricaPeer::ODG_SU_PDL_DI_BILANCIO_IN_COMMISSIONE_1);

		$criteria->addSelectColumn(OppCaricaPeer::INDICE);

		$criteria->addSelectColumn(OppCaricaPeer::SCAGLIONE);

		$criteria->addSelectColumn(OppCaricaPeer::POSIZIONE);

		$criteria->addSelectColumn(OppCaricaPeer::MEDIA);

	}

	const COUNT = 'COUNT(opp_carica.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT opp_carica.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppCaricaPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppCaricaPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = OppCaricaPeer::doSelectRS($criteria, $con);
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
		$objects = OppCaricaPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return OppCaricaPeer::populateObjects(OppCaricaPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			OppCaricaPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = OppCaricaPeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}

	
	public static function doCountJoinOppPolitico(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppCaricaPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppCaricaPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppCaricaPeer::POLITICO_ID, OppPoliticoPeer::ID);

		$rs = OppCaricaPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinOppPolitico(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OppCaricaPeer::addSelectColumns($c);
		$startcol = (OppCaricaPeer::NUM_COLUMNS - OppCaricaPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		OppPoliticoPeer::addSelectColumns($c);

		$c->addJoin(OppCaricaPeer::POLITICO_ID, OppPoliticoPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppCaricaPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = OppPoliticoPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getOppPolitico(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addOppCarica($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initOppCaricas();
				$obj2->addOppCarica($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppCaricaPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppCaricaPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppCaricaPeer::POLITICO_ID, OppPoliticoPeer::ID);

		$rs = OppCaricaPeer::doSelectRS($criteria, $con);
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

		OppCaricaPeer::addSelectColumns($c);
		$startcol2 = (OppCaricaPeer::NUM_COLUMNS - OppCaricaPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OppPoliticoPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OppPoliticoPeer::NUM_COLUMNS;

		$c->addJoin(OppCaricaPeer::POLITICO_ID, OppPoliticoPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppCaricaPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


					
			$omClass = OppPoliticoPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getOppPolitico(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addOppCarica($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initOppCaricas();
				$obj2->addOppCarica($obj1);
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
		return OppCaricaPeer::CLASS_DEFAULT;
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
			$comparison = $criteria->getComparison(OppCaricaPeer::ID);
			$selectCriteria->add(OppCaricaPeer::ID, $criteria->remove(OppCaricaPeer::ID), $comparison);

			$comparison = $criteria->getComparison(OppCaricaPeer::POLITICO_ID);
			$selectCriteria->add(OppCaricaPeer::POLITICO_ID, $criteria->remove(OppCaricaPeer::POLITICO_ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(OppCaricaPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(OppCaricaPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof OppCarica) {

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

			$criteria->add(OppCaricaPeer::ID, $vals[0], Criteria::IN);
			$criteria->add(OppCaricaPeer::POLITICO_ID, $vals[1], Criteria::IN);
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

	
	public static function doValidate(OppCarica $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(OppCaricaPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(OppCaricaPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(OppCaricaPeer::DATABASE_NAME, OppCaricaPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = OppCaricaPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
            $request->setError($col, $failed->getMessage());
        }
    }

    return $res;
	}

	
	public static function retrieveByPK( $id, $politico_id, $con = null) {
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$criteria = new Criteria();
		$criteria->add(OppCaricaPeer::ID, $id);
		$criteria->add(OppCaricaPeer::POLITICO_ID, $politico_id);
		$v = OppCaricaPeer::doSelect($criteria, $con);

		return !empty($v) ? $v[0] : null;
	}
} 
if (Propel::isInit()) {
			try {
		BaseOppCaricaPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/OppCaricaMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.OppCaricaMapBuilder');
}
