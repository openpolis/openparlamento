<?php



class OppCaricaMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.OppCaricaMapBuilder';

	
	private $dbMap;

	
	public function isBuilt()
	{
		return ($this->dbMap !== null);
	}

	
	public function getDatabaseMap()
	{
		return $this->dbMap;
	}

	
	public function doBuild()
	{
		$this->dbMap = Propel::getDatabaseMap('propel');

		$tMap = $this->dbMap->addTable('opp_carica');
		$tMap->setPhpName('OppCarica');

		$tMap->setUseIdGenerator(false);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignPrimaryKey('POLITICO_ID', 'PoliticoId', 'int' , CreoleTypes::INTEGER, 'opp_politico', 'ID', true, null);

		$tMap->addColumn('CARICA', 'Carica', 'string', CreoleTypes::VARCHAR, false, 30);

		$tMap->addColumn('DATA_INIZIO', 'DataInizio', 'int', CreoleTypes::DATE, false, null);

		$tMap->addColumn('DATA_FINE', 'DataFine', 'int', CreoleTypes::DATE, false, null);

		$tMap->addColumn('LEGISLATURA', 'Legislatura', 'int', CreoleTypes::TINYINT, false, null);

		$tMap->addColumn('CIRCOSCRIZIONE', 'Circoscrizione', 'string', CreoleTypes::VARCHAR, false, 60);

		$tMap->addColumn('PRESENZE', 'Presenze', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('ASSENZE', 'Assenze', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('MISSIONI', 'Missioni', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('PARLIAMENT_ID', 'ParliamentId', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('PDL_1', 'Pdl1', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('PDL_2', 'Pdl2', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('MOZIONE_1', 'Mozione1', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('MOZIONE_DI_FIDUCIA_1', 'MozioneDiFiducia1', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('MOZIONE_EX_ART138_COMMA_2_1', 'MozioneExArt138Comma21', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('INTERPELLANZA_1', 'Interpellanza1', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('INTERPELLANZA_URGENTE_1', 'InterpellanzaUrgente1', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('INTERROGAZIONE_A_RISPOSTA_IMMEDIATA_IN_ASSEMBLEA_1', 'InterrogazioneARispostaImmediataInAssemblea1', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('INTERROGAZIONE_A_RISPOSTA_ORALE_1', 'InterrogazioneARispostaOrale1', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('INTERROGAZIONE_A_RISPOSTA_SCRITTA_1', 'InterrogazioneARispostaScritta1', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('INTERROGAZIONE_A_RISPOSTA_IMMEDIATA_IN_COMMISSIONE_1', 'InterrogazioneARispostaImmediataInCommissione1', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('INTERROGAZIONE_A_RISPOSTA_IN_COMMISSIONE_1', 'InterrogazioneARispostaInCommissione1', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('RISOLUZIONE_IN_ASSEMBLEA_1', 'RisoluzioneInAssemblea1', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('RISOLUZIONE_IN_COMMISSIONE_1', 'RisoluzioneInCommissione1', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('RISOLUZIONE_IN_COMMISSIONE_CONCLUSIVA_DI_DIBATTITO_1', 'RisoluzioneInCommissioneConclusivaDiDibattito1', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('ODG_IN_ASSEMBLEA_SU_BILANCIO_INTERNO_1', 'OdgInAssembleaSuBilancioInterno1', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('ODG_IN_ASSEMBLEA_SU_MOZIONI_O_ALTRI_ATTI_1', 'OdgInAssembleaSuMozioniOAltriAtti1', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('ODG_IN_ASSEMBLEA_SU_PDL_1', 'OdgInAssembleaSuPdl1', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('ODG_IN_ASSEMBLEA_SU_PDL_DI_BILANCIO_1', 'OdgInAssembleaSuPdlDiBilancio1', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('ODG_IN_COMMISSIONE_1', 'OdgInCommissione1', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('ODG_SU_PDL_DI_BILANCIO_IN_COMMISSIONE_1', 'OdgSuPdlDiBilancioInCommissione1', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('INDICE', 'Indice', 'double', CreoleTypes::FLOAT, false, null);

		$tMap->addColumn('SCAGLIONE', 'Scaglione', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('POSIZIONE', 'Posizione', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('MEDIA', 'Media', 'double', CreoleTypes::FLOAT, false, null);

	} 
} 