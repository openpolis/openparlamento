<?php


abstract class BaseOppCarica extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $politico_id;


	
	protected $carica;


	
	protected $data_inizio;


	
	protected $data_fine;


	
	protected $legislatura;


	
	protected $circoscrizione;


	
	protected $presenze;


	
	protected $assenze;


	
	protected $missioni;


	
	protected $parliament_id;


	
	protected $pdl_1;


	
	protected $pdl_2;


	
	protected $mozione_1;


	
	protected $mozione_di_fiducia_1;


	
	protected $mozione_ex_art138_comma_2_1;


	
	protected $interpellanza_1;


	
	protected $interpellanza_urgente_1;


	
	protected $interrogazione_a_risposta_immediata_in_assemblea_1;


	
	protected $interrogazione_a_risposta_orale_1;


	
	protected $interrogazione_a_risposta_scritta_1;


	
	protected $interrogazione_a_risposta_immediata_in_commissione_1;


	
	protected $interrogazione_a_risposta_in_commissione_1;


	
	protected $risoluzione_in_assemblea_1;


	
	protected $risoluzione_in_commissione_1;


	
	protected $risoluzione_in_commissione_conclusiva_di_dibattito_1;


	
	protected $odg_in_assemblea_su_bilancio_interno_1;


	
	protected $odg_in_assemblea_su_mozioni_o_altri_atti_1;


	
	protected $odg_in_assemblea_su_pdl_1;


	
	protected $odg_in_assemblea_su_pdl_di_bilancio_1;


	
	protected $odg_in_commissione_1;


	
	protected $odg_su_pdl_di_bilancio_in_commissione_1;


	
	protected $indice;


	
	protected $scaglione;


	
	protected $posizione;


	
	protected $media;

	
	protected $aOppPolitico;

	
	protected $collOppAppoggios;

	
	protected $lastOppAppoggioCriteria = null;

	
	protected $collOppCaricaHasAttos;

	
	protected $lastOppCaricaHasAttoCriteria = null;

	
	protected $collOppCaricaHasGruppos;

	
	protected $lastOppCaricaHasGruppoCriteria = null;

	
	protected $collOppVotazioneHasCaricas;

	
	protected $lastOppVotazioneHasCaricaCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getPoliticoId()
	{

		return $this->politico_id;
	}

	
	public function getCarica()
	{

		return $this->carica;
	}

	
	public function getDataInizio($format = 'Y-m-d')
	{

		if ($this->data_inizio === null || $this->data_inizio === '') {
			return null;
		} elseif (!is_int($this->data_inizio)) {
						$ts = strtotime($this->data_inizio);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [data_inizio] as date/time value: " . var_export($this->data_inizio, true));
			}
		} else {
			$ts = $this->data_inizio;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getDataFine($format = 'Y-m-d')
	{

		if ($this->data_fine === null || $this->data_fine === '') {
			return null;
		} elseif (!is_int($this->data_fine)) {
						$ts = strtotime($this->data_fine);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [data_fine] as date/time value: " . var_export($this->data_fine, true));
			}
		} else {
			$ts = $this->data_fine;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getLegislatura()
	{

		return $this->legislatura;
	}

	
	public function getCircoscrizione()
	{

		return $this->circoscrizione;
	}

	
	public function getPresenze()
	{

		return $this->presenze;
	}

	
	public function getAssenze()
	{

		return $this->assenze;
	}

	
	public function getMissioni()
	{

		return $this->missioni;
	}

	
	public function getParliamentId()
	{

		return $this->parliament_id;
	}

	
	public function getPdl1()
	{

		return $this->pdl_1;
	}

	
	public function getPdl2()
	{

		return $this->pdl_2;
	}

	
	public function getMozione1()
	{

		return $this->mozione_1;
	}

	
	public function getMozioneDiFiducia1()
	{

		return $this->mozione_di_fiducia_1;
	}

	
	public function getMozioneExArt138Comma21()
	{

		return $this->mozione_ex_art138_comma_2_1;
	}

	
	public function getInterpellanza1()
	{

		return $this->interpellanza_1;
	}

	
	public function getInterpellanzaUrgente1()
	{

		return $this->interpellanza_urgente_1;
	}

	
	public function getInterrogazioneARispostaImmediataInAssemblea1()
	{

		return $this->interrogazione_a_risposta_immediata_in_assemblea_1;
	}

	
	public function getInterrogazioneARispostaOrale1()
	{

		return $this->interrogazione_a_risposta_orale_1;
	}

	
	public function getInterrogazioneARispostaScritta1()
	{

		return $this->interrogazione_a_risposta_scritta_1;
	}

	
	public function getInterrogazioneARispostaImmediataInCommissione1()
	{

		return $this->interrogazione_a_risposta_immediata_in_commissione_1;
	}

	
	public function getInterrogazioneARispostaInCommissione1()
	{

		return $this->interrogazione_a_risposta_in_commissione_1;
	}

	
	public function getRisoluzioneInAssemblea1()
	{

		return $this->risoluzione_in_assemblea_1;
	}

	
	public function getRisoluzioneInCommissione1()
	{

		return $this->risoluzione_in_commissione_1;
	}

	
	public function getRisoluzioneInCommissioneConclusivaDiDibattito1()
	{

		return $this->risoluzione_in_commissione_conclusiva_di_dibattito_1;
	}

	
	public function getOdgInAssembleaSuBilancioInterno1()
	{

		return $this->odg_in_assemblea_su_bilancio_interno_1;
	}

	
	public function getOdgInAssembleaSuMozioniOAltriAtti1()
	{

		return $this->odg_in_assemblea_su_mozioni_o_altri_atti_1;
	}

	
	public function getOdgInAssembleaSuPdl1()
	{

		return $this->odg_in_assemblea_su_pdl_1;
	}

	
	public function getOdgInAssembleaSuPdlDiBilancio1()
	{

		return $this->odg_in_assemblea_su_pdl_di_bilancio_1;
	}

	
	public function getOdgInCommissione1()
	{

		return $this->odg_in_commissione_1;
	}

	
	public function getOdgSuPdlDiBilancioInCommissione1()
	{

		return $this->odg_su_pdl_di_bilancio_in_commissione_1;
	}

	
	public function getIndice()
	{

		return $this->indice;
	}

	
	public function getScaglione()
	{

		return $this->scaglione;
	}

	
	public function getPosizione()
	{

		return $this->posizione;
	}

	
	public function getMedia()
	{

		return $this->media;
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = OppCaricaPeer::ID;
		}

	} 
	
	public function setPoliticoId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->politico_id !== $v) {
			$this->politico_id = $v;
			$this->modifiedColumns[] = OppCaricaPeer::POLITICO_ID;
		}

		if ($this->aOppPolitico !== null && $this->aOppPolitico->getId() !== $v) {
			$this->aOppPolitico = null;
		}

	} 
	
	public function setCarica($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->carica !== $v) {
			$this->carica = $v;
			$this->modifiedColumns[] = OppCaricaPeer::CARICA;
		}

	} 
	
	public function setDataInizio($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [data_inizio] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->data_inizio !== $ts) {
			$this->data_inizio = $ts;
			$this->modifiedColumns[] = OppCaricaPeer::DATA_INIZIO;
		}

	} 
	
	public function setDataFine($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [data_fine] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->data_fine !== $ts) {
			$this->data_fine = $ts;
			$this->modifiedColumns[] = OppCaricaPeer::DATA_FINE;
		}

	} 
	
	public function setLegislatura($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->legislatura !== $v) {
			$this->legislatura = $v;
			$this->modifiedColumns[] = OppCaricaPeer::LEGISLATURA;
		}

	} 
	
	public function setCircoscrizione($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->circoscrizione !== $v) {
			$this->circoscrizione = $v;
			$this->modifiedColumns[] = OppCaricaPeer::CIRCOSCRIZIONE;
		}

	} 
	
	public function setPresenze($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->presenze !== $v) {
			$this->presenze = $v;
			$this->modifiedColumns[] = OppCaricaPeer::PRESENZE;
		}

	} 
	
	public function setAssenze($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->assenze !== $v) {
			$this->assenze = $v;
			$this->modifiedColumns[] = OppCaricaPeer::ASSENZE;
		}

	} 
	
	public function setMissioni($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->missioni !== $v) {
			$this->missioni = $v;
			$this->modifiedColumns[] = OppCaricaPeer::MISSIONI;
		}

	} 
	
	public function setParliamentId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->parliament_id !== $v) {
			$this->parliament_id = $v;
			$this->modifiedColumns[] = OppCaricaPeer::PARLIAMENT_ID;
		}

	} 
	
	public function setPdl1($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->pdl_1 !== $v) {
			$this->pdl_1 = $v;
			$this->modifiedColumns[] = OppCaricaPeer::PDL_1;
		}

	} 
	
	public function setPdl2($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->pdl_2 !== $v) {
			$this->pdl_2 = $v;
			$this->modifiedColumns[] = OppCaricaPeer::PDL_2;
		}

	} 
	
	public function setMozione1($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->mozione_1 !== $v) {
			$this->mozione_1 = $v;
			$this->modifiedColumns[] = OppCaricaPeer::MOZIONE_1;
		}

	} 
	
	public function setMozioneDiFiducia1($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->mozione_di_fiducia_1 !== $v) {
			$this->mozione_di_fiducia_1 = $v;
			$this->modifiedColumns[] = OppCaricaPeer::MOZIONE_DI_FIDUCIA_1;
		}

	} 
	
	public function setMozioneExArt138Comma21($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->mozione_ex_art138_comma_2_1 !== $v) {
			$this->mozione_ex_art138_comma_2_1 = $v;
			$this->modifiedColumns[] = OppCaricaPeer::MOZIONE_EX_ART138_COMMA_2_1;
		}

	} 
	
	public function setInterpellanza1($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->interpellanza_1 !== $v) {
			$this->interpellanza_1 = $v;
			$this->modifiedColumns[] = OppCaricaPeer::INTERPELLANZA_1;
		}

	} 
	
	public function setInterpellanzaUrgente1($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->interpellanza_urgente_1 !== $v) {
			$this->interpellanza_urgente_1 = $v;
			$this->modifiedColumns[] = OppCaricaPeer::INTERPELLANZA_URGENTE_1;
		}

	} 
	
	public function setInterrogazioneARispostaImmediataInAssemblea1($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->interrogazione_a_risposta_immediata_in_assemblea_1 !== $v) {
			$this->interrogazione_a_risposta_immediata_in_assemblea_1 = $v;
			$this->modifiedColumns[] = OppCaricaPeer::INTERROGAZIONE_A_RISPOSTA_IMMEDIATA_IN_ASSEMBLEA_1;
		}

	} 
	
	public function setInterrogazioneARispostaOrale1($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->interrogazione_a_risposta_orale_1 !== $v) {
			$this->interrogazione_a_risposta_orale_1 = $v;
			$this->modifiedColumns[] = OppCaricaPeer::INTERROGAZIONE_A_RISPOSTA_ORALE_1;
		}

	} 
	
	public function setInterrogazioneARispostaScritta1($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->interrogazione_a_risposta_scritta_1 !== $v) {
			$this->interrogazione_a_risposta_scritta_1 = $v;
			$this->modifiedColumns[] = OppCaricaPeer::INTERROGAZIONE_A_RISPOSTA_SCRITTA_1;
		}

	} 
	
	public function setInterrogazioneARispostaImmediataInCommissione1($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->interrogazione_a_risposta_immediata_in_commissione_1 !== $v) {
			$this->interrogazione_a_risposta_immediata_in_commissione_1 = $v;
			$this->modifiedColumns[] = OppCaricaPeer::INTERROGAZIONE_A_RISPOSTA_IMMEDIATA_IN_COMMISSIONE_1;
		}

	} 
	
	public function setInterrogazioneARispostaInCommissione1($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->interrogazione_a_risposta_in_commissione_1 !== $v) {
			$this->interrogazione_a_risposta_in_commissione_1 = $v;
			$this->modifiedColumns[] = OppCaricaPeer::INTERROGAZIONE_A_RISPOSTA_IN_COMMISSIONE_1;
		}

	} 
	
	public function setRisoluzioneInAssemblea1($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->risoluzione_in_assemblea_1 !== $v) {
			$this->risoluzione_in_assemblea_1 = $v;
			$this->modifiedColumns[] = OppCaricaPeer::RISOLUZIONE_IN_ASSEMBLEA_1;
		}

	} 
	
	public function setRisoluzioneInCommissione1($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->risoluzione_in_commissione_1 !== $v) {
			$this->risoluzione_in_commissione_1 = $v;
			$this->modifiedColumns[] = OppCaricaPeer::RISOLUZIONE_IN_COMMISSIONE_1;
		}

	} 
	
	public function setRisoluzioneInCommissioneConclusivaDiDibattito1($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->risoluzione_in_commissione_conclusiva_di_dibattito_1 !== $v) {
			$this->risoluzione_in_commissione_conclusiva_di_dibattito_1 = $v;
			$this->modifiedColumns[] = OppCaricaPeer::RISOLUZIONE_IN_COMMISSIONE_CONCLUSIVA_DI_DIBATTITO_1;
		}

	} 
	
	public function setOdgInAssembleaSuBilancioInterno1($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->odg_in_assemblea_su_bilancio_interno_1 !== $v) {
			$this->odg_in_assemblea_su_bilancio_interno_1 = $v;
			$this->modifiedColumns[] = OppCaricaPeer::ODG_IN_ASSEMBLEA_SU_BILANCIO_INTERNO_1;
		}

	} 
	
	public function setOdgInAssembleaSuMozioniOAltriAtti1($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->odg_in_assemblea_su_mozioni_o_altri_atti_1 !== $v) {
			$this->odg_in_assemblea_su_mozioni_o_altri_atti_1 = $v;
			$this->modifiedColumns[] = OppCaricaPeer::ODG_IN_ASSEMBLEA_SU_MOZIONI_O_ALTRI_ATTI_1;
		}

	} 
	
	public function setOdgInAssembleaSuPdl1($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->odg_in_assemblea_su_pdl_1 !== $v) {
			$this->odg_in_assemblea_su_pdl_1 = $v;
			$this->modifiedColumns[] = OppCaricaPeer::ODG_IN_ASSEMBLEA_SU_PDL_1;
		}

	} 
	
	public function setOdgInAssembleaSuPdlDiBilancio1($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->odg_in_assemblea_su_pdl_di_bilancio_1 !== $v) {
			$this->odg_in_assemblea_su_pdl_di_bilancio_1 = $v;
			$this->modifiedColumns[] = OppCaricaPeer::ODG_IN_ASSEMBLEA_SU_PDL_DI_BILANCIO_1;
		}

	} 
	
	public function setOdgInCommissione1($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->odg_in_commissione_1 !== $v) {
			$this->odg_in_commissione_1 = $v;
			$this->modifiedColumns[] = OppCaricaPeer::ODG_IN_COMMISSIONE_1;
		}

	} 
	
	public function setOdgSuPdlDiBilancioInCommissione1($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->odg_su_pdl_di_bilancio_in_commissione_1 !== $v) {
			$this->odg_su_pdl_di_bilancio_in_commissione_1 = $v;
			$this->modifiedColumns[] = OppCaricaPeer::ODG_SU_PDL_DI_BILANCIO_IN_COMMISSIONE_1;
		}

	} 
	
	public function setIndice($v)
	{

		if ($this->indice !== $v) {
			$this->indice = $v;
			$this->modifiedColumns[] = OppCaricaPeer::INDICE;
		}

	} 
	
	public function setScaglione($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->scaglione !== $v) {
			$this->scaglione = $v;
			$this->modifiedColumns[] = OppCaricaPeer::SCAGLIONE;
		}

	} 
	
	public function setPosizione($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->posizione !== $v) {
			$this->posizione = $v;
			$this->modifiedColumns[] = OppCaricaPeer::POSIZIONE;
		}

	} 
	
	public function setMedia($v)
	{

		if ($this->media !== $v) {
			$this->media = $v;
			$this->modifiedColumns[] = OppCaricaPeer::MEDIA;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->politico_id = $rs->getInt($startcol + 1);

			$this->carica = $rs->getString($startcol + 2);

			$this->data_inizio = $rs->getDate($startcol + 3, null);

			$this->data_fine = $rs->getDate($startcol + 4, null);

			$this->legislatura = $rs->getInt($startcol + 5);

			$this->circoscrizione = $rs->getString($startcol + 6);

			$this->presenze = $rs->getInt($startcol + 7);

			$this->assenze = $rs->getInt($startcol + 8);

			$this->missioni = $rs->getInt($startcol + 9);

			$this->parliament_id = $rs->getInt($startcol + 10);

			$this->pdl_1 = $rs->getInt($startcol + 11);

			$this->pdl_2 = $rs->getInt($startcol + 12);

			$this->mozione_1 = $rs->getInt($startcol + 13);

			$this->mozione_di_fiducia_1 = $rs->getInt($startcol + 14);

			$this->mozione_ex_art138_comma_2_1 = $rs->getInt($startcol + 15);

			$this->interpellanza_1 = $rs->getInt($startcol + 16);

			$this->interpellanza_urgente_1 = $rs->getInt($startcol + 17);

			$this->interrogazione_a_risposta_immediata_in_assemblea_1 = $rs->getInt($startcol + 18);

			$this->interrogazione_a_risposta_orale_1 = $rs->getInt($startcol + 19);

			$this->interrogazione_a_risposta_scritta_1 = $rs->getInt($startcol + 20);

			$this->interrogazione_a_risposta_immediata_in_commissione_1 = $rs->getInt($startcol + 21);

			$this->interrogazione_a_risposta_in_commissione_1 = $rs->getInt($startcol + 22);

			$this->risoluzione_in_assemblea_1 = $rs->getInt($startcol + 23);

			$this->risoluzione_in_commissione_1 = $rs->getInt($startcol + 24);

			$this->risoluzione_in_commissione_conclusiva_di_dibattito_1 = $rs->getInt($startcol + 25);

			$this->odg_in_assemblea_su_bilancio_interno_1 = $rs->getInt($startcol + 26);

			$this->odg_in_assemblea_su_mozioni_o_altri_atti_1 = $rs->getInt($startcol + 27);

			$this->odg_in_assemblea_su_pdl_1 = $rs->getInt($startcol + 28);

			$this->odg_in_assemblea_su_pdl_di_bilancio_1 = $rs->getInt($startcol + 29);

			$this->odg_in_commissione_1 = $rs->getInt($startcol + 30);

			$this->odg_su_pdl_di_bilancio_in_commissione_1 = $rs->getInt($startcol + 31);

			$this->indice = $rs->getFloat($startcol + 32);

			$this->scaglione = $rs->getInt($startcol + 33);

			$this->posizione = $rs->getInt($startcol + 34);

			$this->media = $rs->getFloat($startcol + 35);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 36; 
		} catch (Exception $e) {
			throw new PropelException("Error populating OppCarica object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(OppCaricaPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			OppCaricaPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(OppCaricaPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	protected function doSave($con)
	{
		$affectedRows = 0; 		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;


												
			if ($this->aOppPolitico !== null) {
				if ($this->aOppPolitico->isModified()) {
					$affectedRows += $this->aOppPolitico->save($con);
				}
				$this->setOppPolitico($this->aOppPolitico);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = OppCaricaPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setNew(false);
				} else {
					$affectedRows += OppCaricaPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collOppAppoggios !== null) {
				foreach($this->collOppAppoggios as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collOppCaricaHasAttos !== null) {
				foreach($this->collOppCaricaHasAttos as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collOppCaricaHasGruppos !== null) {
				foreach($this->collOppCaricaHasGruppos as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collOppVotazioneHasCaricas !== null) {
				foreach($this->collOppVotazioneHasCaricas as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			$this->alreadyInSave = false;
		}
		return $affectedRows;
	} 
	
	protected $validationFailures = array();

	
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


												
			if ($this->aOppPolitico !== null) {
				if (!$this->aOppPolitico->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOppPolitico->getValidationFailures());
				}
			}


			if (($retval = OppCaricaPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collOppAppoggios !== null) {
					foreach($this->collOppAppoggios as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collOppCaricaHasAttos !== null) {
					foreach($this->collOppCaricaHasAttos as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collOppCaricaHasGruppos !== null) {
					foreach($this->collOppCaricaHasGruppos as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collOppVotazioneHasCaricas !== null) {
					foreach($this->collOppVotazioneHasCaricas as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}


			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppCaricaPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getPoliticoId();
				break;
			case 2:
				return $this->getCarica();
				break;
			case 3:
				return $this->getDataInizio();
				break;
			case 4:
				return $this->getDataFine();
				break;
			case 5:
				return $this->getLegislatura();
				break;
			case 6:
				return $this->getCircoscrizione();
				break;
			case 7:
				return $this->getPresenze();
				break;
			case 8:
				return $this->getAssenze();
				break;
			case 9:
				return $this->getMissioni();
				break;
			case 10:
				return $this->getParliamentId();
				break;
			case 11:
				return $this->getPdl1();
				break;
			case 12:
				return $this->getPdl2();
				break;
			case 13:
				return $this->getMozione1();
				break;
			case 14:
				return $this->getMozioneDiFiducia1();
				break;
			case 15:
				return $this->getMozioneExArt138Comma21();
				break;
			case 16:
				return $this->getInterpellanza1();
				break;
			case 17:
				return $this->getInterpellanzaUrgente1();
				break;
			case 18:
				return $this->getInterrogazioneARispostaImmediataInAssemblea1();
				break;
			case 19:
				return $this->getInterrogazioneARispostaOrale1();
				break;
			case 20:
				return $this->getInterrogazioneARispostaScritta1();
				break;
			case 21:
				return $this->getInterrogazioneARispostaImmediataInCommissione1();
				break;
			case 22:
				return $this->getInterrogazioneARispostaInCommissione1();
				break;
			case 23:
				return $this->getRisoluzioneInAssemblea1();
				break;
			case 24:
				return $this->getRisoluzioneInCommissione1();
				break;
			case 25:
				return $this->getRisoluzioneInCommissioneConclusivaDiDibattito1();
				break;
			case 26:
				return $this->getOdgInAssembleaSuBilancioInterno1();
				break;
			case 27:
				return $this->getOdgInAssembleaSuMozioniOAltriAtti1();
				break;
			case 28:
				return $this->getOdgInAssembleaSuPdl1();
				break;
			case 29:
				return $this->getOdgInAssembleaSuPdlDiBilancio1();
				break;
			case 30:
				return $this->getOdgInCommissione1();
				break;
			case 31:
				return $this->getOdgSuPdlDiBilancioInCommissione1();
				break;
			case 32:
				return $this->getIndice();
				break;
			case 33:
				return $this->getScaglione();
				break;
			case 34:
				return $this->getPosizione();
				break;
			case 35:
				return $this->getMedia();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppCaricaPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getPoliticoId(),
			$keys[2] => $this->getCarica(),
			$keys[3] => $this->getDataInizio(),
			$keys[4] => $this->getDataFine(),
			$keys[5] => $this->getLegislatura(),
			$keys[6] => $this->getCircoscrizione(),
			$keys[7] => $this->getPresenze(),
			$keys[8] => $this->getAssenze(),
			$keys[9] => $this->getMissioni(),
			$keys[10] => $this->getParliamentId(),
			$keys[11] => $this->getPdl1(),
			$keys[12] => $this->getPdl2(),
			$keys[13] => $this->getMozione1(),
			$keys[14] => $this->getMozioneDiFiducia1(),
			$keys[15] => $this->getMozioneExArt138Comma21(),
			$keys[16] => $this->getInterpellanza1(),
			$keys[17] => $this->getInterpellanzaUrgente1(),
			$keys[18] => $this->getInterrogazioneARispostaImmediataInAssemblea1(),
			$keys[19] => $this->getInterrogazioneARispostaOrale1(),
			$keys[20] => $this->getInterrogazioneARispostaScritta1(),
			$keys[21] => $this->getInterrogazioneARispostaImmediataInCommissione1(),
			$keys[22] => $this->getInterrogazioneARispostaInCommissione1(),
			$keys[23] => $this->getRisoluzioneInAssemblea1(),
			$keys[24] => $this->getRisoluzioneInCommissione1(),
			$keys[25] => $this->getRisoluzioneInCommissioneConclusivaDiDibattito1(),
			$keys[26] => $this->getOdgInAssembleaSuBilancioInterno1(),
			$keys[27] => $this->getOdgInAssembleaSuMozioniOAltriAtti1(),
			$keys[28] => $this->getOdgInAssembleaSuPdl1(),
			$keys[29] => $this->getOdgInAssembleaSuPdlDiBilancio1(),
			$keys[30] => $this->getOdgInCommissione1(),
			$keys[31] => $this->getOdgSuPdlDiBilancioInCommissione1(),
			$keys[32] => $this->getIndice(),
			$keys[33] => $this->getScaglione(),
			$keys[34] => $this->getPosizione(),
			$keys[35] => $this->getMedia(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppCaricaPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setPoliticoId($value);
				break;
			case 2:
				$this->setCarica($value);
				break;
			case 3:
				$this->setDataInizio($value);
				break;
			case 4:
				$this->setDataFine($value);
				break;
			case 5:
				$this->setLegislatura($value);
				break;
			case 6:
				$this->setCircoscrizione($value);
				break;
			case 7:
				$this->setPresenze($value);
				break;
			case 8:
				$this->setAssenze($value);
				break;
			case 9:
				$this->setMissioni($value);
				break;
			case 10:
				$this->setParliamentId($value);
				break;
			case 11:
				$this->setPdl1($value);
				break;
			case 12:
				$this->setPdl2($value);
				break;
			case 13:
				$this->setMozione1($value);
				break;
			case 14:
				$this->setMozioneDiFiducia1($value);
				break;
			case 15:
				$this->setMozioneExArt138Comma21($value);
				break;
			case 16:
				$this->setInterpellanza1($value);
				break;
			case 17:
				$this->setInterpellanzaUrgente1($value);
				break;
			case 18:
				$this->setInterrogazioneARispostaImmediataInAssemblea1($value);
				break;
			case 19:
				$this->setInterrogazioneARispostaOrale1($value);
				break;
			case 20:
				$this->setInterrogazioneARispostaScritta1($value);
				break;
			case 21:
				$this->setInterrogazioneARispostaImmediataInCommissione1($value);
				break;
			case 22:
				$this->setInterrogazioneARispostaInCommissione1($value);
				break;
			case 23:
				$this->setRisoluzioneInAssemblea1($value);
				break;
			case 24:
				$this->setRisoluzioneInCommissione1($value);
				break;
			case 25:
				$this->setRisoluzioneInCommissioneConclusivaDiDibattito1($value);
				break;
			case 26:
				$this->setOdgInAssembleaSuBilancioInterno1($value);
				break;
			case 27:
				$this->setOdgInAssembleaSuMozioniOAltriAtti1($value);
				break;
			case 28:
				$this->setOdgInAssembleaSuPdl1($value);
				break;
			case 29:
				$this->setOdgInAssembleaSuPdlDiBilancio1($value);
				break;
			case 30:
				$this->setOdgInCommissione1($value);
				break;
			case 31:
				$this->setOdgSuPdlDiBilancioInCommissione1($value);
				break;
			case 32:
				$this->setIndice($value);
				break;
			case 33:
				$this->setScaglione($value);
				break;
			case 34:
				$this->setPosizione($value);
				break;
			case 35:
				$this->setMedia($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppCaricaPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setPoliticoId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setCarica($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setDataInizio($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setDataFine($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setLegislatura($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setCircoscrizione($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setPresenze($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setAssenze($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setMissioni($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setParliamentId($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setPdl1($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setPdl2($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setMozione1($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setMozioneDiFiducia1($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setMozioneExArt138Comma21($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setInterpellanza1($arr[$keys[16]]);
		if (array_key_exists($keys[17], $arr)) $this->setInterpellanzaUrgente1($arr[$keys[17]]);
		if (array_key_exists($keys[18], $arr)) $this->setInterrogazioneARispostaImmediataInAssemblea1($arr[$keys[18]]);
		if (array_key_exists($keys[19], $arr)) $this->setInterrogazioneARispostaOrale1($arr[$keys[19]]);
		if (array_key_exists($keys[20], $arr)) $this->setInterrogazioneARispostaScritta1($arr[$keys[20]]);
		if (array_key_exists($keys[21], $arr)) $this->setInterrogazioneARispostaImmediataInCommissione1($arr[$keys[21]]);
		if (array_key_exists($keys[22], $arr)) $this->setInterrogazioneARispostaInCommissione1($arr[$keys[22]]);
		if (array_key_exists($keys[23], $arr)) $this->setRisoluzioneInAssemblea1($arr[$keys[23]]);
		if (array_key_exists($keys[24], $arr)) $this->setRisoluzioneInCommissione1($arr[$keys[24]]);
		if (array_key_exists($keys[25], $arr)) $this->setRisoluzioneInCommissioneConclusivaDiDibattito1($arr[$keys[25]]);
		if (array_key_exists($keys[26], $arr)) $this->setOdgInAssembleaSuBilancioInterno1($arr[$keys[26]]);
		if (array_key_exists($keys[27], $arr)) $this->setOdgInAssembleaSuMozioniOAltriAtti1($arr[$keys[27]]);
		if (array_key_exists($keys[28], $arr)) $this->setOdgInAssembleaSuPdl1($arr[$keys[28]]);
		if (array_key_exists($keys[29], $arr)) $this->setOdgInAssembleaSuPdlDiBilancio1($arr[$keys[29]]);
		if (array_key_exists($keys[30], $arr)) $this->setOdgInCommissione1($arr[$keys[30]]);
		if (array_key_exists($keys[31], $arr)) $this->setOdgSuPdlDiBilancioInCommissione1($arr[$keys[31]]);
		if (array_key_exists($keys[32], $arr)) $this->setIndice($arr[$keys[32]]);
		if (array_key_exists($keys[33], $arr)) $this->setScaglione($arr[$keys[33]]);
		if (array_key_exists($keys[34], $arr)) $this->setPosizione($arr[$keys[34]]);
		if (array_key_exists($keys[35], $arr)) $this->setMedia($arr[$keys[35]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(OppCaricaPeer::DATABASE_NAME);

		if ($this->isColumnModified(OppCaricaPeer::ID)) $criteria->add(OppCaricaPeer::ID, $this->id);
		if ($this->isColumnModified(OppCaricaPeer::POLITICO_ID)) $criteria->add(OppCaricaPeer::POLITICO_ID, $this->politico_id);
		if ($this->isColumnModified(OppCaricaPeer::CARICA)) $criteria->add(OppCaricaPeer::CARICA, $this->carica);
		if ($this->isColumnModified(OppCaricaPeer::DATA_INIZIO)) $criteria->add(OppCaricaPeer::DATA_INIZIO, $this->data_inizio);
		if ($this->isColumnModified(OppCaricaPeer::DATA_FINE)) $criteria->add(OppCaricaPeer::DATA_FINE, $this->data_fine);
		if ($this->isColumnModified(OppCaricaPeer::LEGISLATURA)) $criteria->add(OppCaricaPeer::LEGISLATURA, $this->legislatura);
		if ($this->isColumnModified(OppCaricaPeer::CIRCOSCRIZIONE)) $criteria->add(OppCaricaPeer::CIRCOSCRIZIONE, $this->circoscrizione);
		if ($this->isColumnModified(OppCaricaPeer::PRESENZE)) $criteria->add(OppCaricaPeer::PRESENZE, $this->presenze);
		if ($this->isColumnModified(OppCaricaPeer::ASSENZE)) $criteria->add(OppCaricaPeer::ASSENZE, $this->assenze);
		if ($this->isColumnModified(OppCaricaPeer::MISSIONI)) $criteria->add(OppCaricaPeer::MISSIONI, $this->missioni);
		if ($this->isColumnModified(OppCaricaPeer::PARLIAMENT_ID)) $criteria->add(OppCaricaPeer::PARLIAMENT_ID, $this->parliament_id);
		if ($this->isColumnModified(OppCaricaPeer::PDL_1)) $criteria->add(OppCaricaPeer::PDL_1, $this->pdl_1);
		if ($this->isColumnModified(OppCaricaPeer::PDL_2)) $criteria->add(OppCaricaPeer::PDL_2, $this->pdl_2);
		if ($this->isColumnModified(OppCaricaPeer::MOZIONE_1)) $criteria->add(OppCaricaPeer::MOZIONE_1, $this->mozione_1);
		if ($this->isColumnModified(OppCaricaPeer::MOZIONE_DI_FIDUCIA_1)) $criteria->add(OppCaricaPeer::MOZIONE_DI_FIDUCIA_1, $this->mozione_di_fiducia_1);
		if ($this->isColumnModified(OppCaricaPeer::MOZIONE_EX_ART138_COMMA_2_1)) $criteria->add(OppCaricaPeer::MOZIONE_EX_ART138_COMMA_2_1, $this->mozione_ex_art138_comma_2_1);
		if ($this->isColumnModified(OppCaricaPeer::INTERPELLANZA_1)) $criteria->add(OppCaricaPeer::INTERPELLANZA_1, $this->interpellanza_1);
		if ($this->isColumnModified(OppCaricaPeer::INTERPELLANZA_URGENTE_1)) $criteria->add(OppCaricaPeer::INTERPELLANZA_URGENTE_1, $this->interpellanza_urgente_1);
		if ($this->isColumnModified(OppCaricaPeer::INTERROGAZIONE_A_RISPOSTA_IMMEDIATA_IN_ASSEMBLEA_1)) $criteria->add(OppCaricaPeer::INTERROGAZIONE_A_RISPOSTA_IMMEDIATA_IN_ASSEMBLEA_1, $this->interrogazione_a_risposta_immediata_in_assemblea_1);
		if ($this->isColumnModified(OppCaricaPeer::INTERROGAZIONE_A_RISPOSTA_ORALE_1)) $criteria->add(OppCaricaPeer::INTERROGAZIONE_A_RISPOSTA_ORALE_1, $this->interrogazione_a_risposta_orale_1);
		if ($this->isColumnModified(OppCaricaPeer::INTERROGAZIONE_A_RISPOSTA_SCRITTA_1)) $criteria->add(OppCaricaPeer::INTERROGAZIONE_A_RISPOSTA_SCRITTA_1, $this->interrogazione_a_risposta_scritta_1);
		if ($this->isColumnModified(OppCaricaPeer::INTERROGAZIONE_A_RISPOSTA_IMMEDIATA_IN_COMMISSIONE_1)) $criteria->add(OppCaricaPeer::INTERROGAZIONE_A_RISPOSTA_IMMEDIATA_IN_COMMISSIONE_1, $this->interrogazione_a_risposta_immediata_in_commissione_1);
		if ($this->isColumnModified(OppCaricaPeer::INTERROGAZIONE_A_RISPOSTA_IN_COMMISSIONE_1)) $criteria->add(OppCaricaPeer::INTERROGAZIONE_A_RISPOSTA_IN_COMMISSIONE_1, $this->interrogazione_a_risposta_in_commissione_1);
		if ($this->isColumnModified(OppCaricaPeer::RISOLUZIONE_IN_ASSEMBLEA_1)) $criteria->add(OppCaricaPeer::RISOLUZIONE_IN_ASSEMBLEA_1, $this->risoluzione_in_assemblea_1);
		if ($this->isColumnModified(OppCaricaPeer::RISOLUZIONE_IN_COMMISSIONE_1)) $criteria->add(OppCaricaPeer::RISOLUZIONE_IN_COMMISSIONE_1, $this->risoluzione_in_commissione_1);
		if ($this->isColumnModified(OppCaricaPeer::RISOLUZIONE_IN_COMMISSIONE_CONCLUSIVA_DI_DIBATTITO_1)) $criteria->add(OppCaricaPeer::RISOLUZIONE_IN_COMMISSIONE_CONCLUSIVA_DI_DIBATTITO_1, $this->risoluzione_in_commissione_conclusiva_di_dibattito_1);
		if ($this->isColumnModified(OppCaricaPeer::ODG_IN_ASSEMBLEA_SU_BILANCIO_INTERNO_1)) $criteria->add(OppCaricaPeer::ODG_IN_ASSEMBLEA_SU_BILANCIO_INTERNO_1, $this->odg_in_assemblea_su_bilancio_interno_1);
		if ($this->isColumnModified(OppCaricaPeer::ODG_IN_ASSEMBLEA_SU_MOZIONI_O_ALTRI_ATTI_1)) $criteria->add(OppCaricaPeer::ODG_IN_ASSEMBLEA_SU_MOZIONI_O_ALTRI_ATTI_1, $this->odg_in_assemblea_su_mozioni_o_altri_atti_1);
		if ($this->isColumnModified(OppCaricaPeer::ODG_IN_ASSEMBLEA_SU_PDL_1)) $criteria->add(OppCaricaPeer::ODG_IN_ASSEMBLEA_SU_PDL_1, $this->odg_in_assemblea_su_pdl_1);
		if ($this->isColumnModified(OppCaricaPeer::ODG_IN_ASSEMBLEA_SU_PDL_DI_BILANCIO_1)) $criteria->add(OppCaricaPeer::ODG_IN_ASSEMBLEA_SU_PDL_DI_BILANCIO_1, $this->odg_in_assemblea_su_pdl_di_bilancio_1);
		if ($this->isColumnModified(OppCaricaPeer::ODG_IN_COMMISSIONE_1)) $criteria->add(OppCaricaPeer::ODG_IN_COMMISSIONE_1, $this->odg_in_commissione_1);
		if ($this->isColumnModified(OppCaricaPeer::ODG_SU_PDL_DI_BILANCIO_IN_COMMISSIONE_1)) $criteria->add(OppCaricaPeer::ODG_SU_PDL_DI_BILANCIO_IN_COMMISSIONE_1, $this->odg_su_pdl_di_bilancio_in_commissione_1);
		if ($this->isColumnModified(OppCaricaPeer::INDICE)) $criteria->add(OppCaricaPeer::INDICE, $this->indice);
		if ($this->isColumnModified(OppCaricaPeer::SCAGLIONE)) $criteria->add(OppCaricaPeer::SCAGLIONE, $this->scaglione);
		if ($this->isColumnModified(OppCaricaPeer::POSIZIONE)) $criteria->add(OppCaricaPeer::POSIZIONE, $this->posizione);
		if ($this->isColumnModified(OppCaricaPeer::MEDIA)) $criteria->add(OppCaricaPeer::MEDIA, $this->media);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(OppCaricaPeer::DATABASE_NAME);

		$criteria->add(OppCaricaPeer::ID, $this->id);
		$criteria->add(OppCaricaPeer::POLITICO_ID, $this->politico_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getId();

		$pks[1] = $this->getPoliticoId();

		return $pks;
	}

	
	public function setPrimaryKey($keys)
	{

		$this->setId($keys[0]);

		$this->setPoliticoId($keys[1]);

	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCarica($this->carica);

		$copyObj->setDataInizio($this->data_inizio);

		$copyObj->setDataFine($this->data_fine);

		$copyObj->setLegislatura($this->legislatura);

		$copyObj->setCircoscrizione($this->circoscrizione);

		$copyObj->setPresenze($this->presenze);

		$copyObj->setAssenze($this->assenze);

		$copyObj->setMissioni($this->missioni);

		$copyObj->setParliamentId($this->parliament_id);

		$copyObj->setPdl1($this->pdl_1);

		$copyObj->setPdl2($this->pdl_2);

		$copyObj->setMozione1($this->mozione_1);

		$copyObj->setMozioneDiFiducia1($this->mozione_di_fiducia_1);

		$copyObj->setMozioneExArt138Comma21($this->mozione_ex_art138_comma_2_1);

		$copyObj->setInterpellanza1($this->interpellanza_1);

		$copyObj->setInterpellanzaUrgente1($this->interpellanza_urgente_1);

		$copyObj->setInterrogazioneARispostaImmediataInAssemblea1($this->interrogazione_a_risposta_immediata_in_assemblea_1);

		$copyObj->setInterrogazioneARispostaOrale1($this->interrogazione_a_risposta_orale_1);

		$copyObj->setInterrogazioneARispostaScritta1($this->interrogazione_a_risposta_scritta_1);

		$copyObj->setInterrogazioneARispostaImmediataInCommissione1($this->interrogazione_a_risposta_immediata_in_commissione_1);

		$copyObj->setInterrogazioneARispostaInCommissione1($this->interrogazione_a_risposta_in_commissione_1);

		$copyObj->setRisoluzioneInAssemblea1($this->risoluzione_in_assemblea_1);

		$copyObj->setRisoluzioneInCommissione1($this->risoluzione_in_commissione_1);

		$copyObj->setRisoluzioneInCommissioneConclusivaDiDibattito1($this->risoluzione_in_commissione_conclusiva_di_dibattito_1);

		$copyObj->setOdgInAssembleaSuBilancioInterno1($this->odg_in_assemblea_su_bilancio_interno_1);

		$copyObj->setOdgInAssembleaSuMozioniOAltriAtti1($this->odg_in_assemblea_su_mozioni_o_altri_atti_1);

		$copyObj->setOdgInAssembleaSuPdl1($this->odg_in_assemblea_su_pdl_1);

		$copyObj->setOdgInAssembleaSuPdlDiBilancio1($this->odg_in_assemblea_su_pdl_di_bilancio_1);

		$copyObj->setOdgInCommissione1($this->odg_in_commissione_1);

		$copyObj->setOdgSuPdlDiBilancioInCommissione1($this->odg_su_pdl_di_bilancio_in_commissione_1);

		$copyObj->setIndice($this->indice);

		$copyObj->setScaglione($this->scaglione);

		$copyObj->setPosizione($this->posizione);

		$copyObj->setMedia($this->media);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getOppAppoggios() as $relObj) {
				$copyObj->addOppAppoggio($relObj->copy($deepCopy));
			}

			foreach($this->getOppCaricaHasAttos() as $relObj) {
				$copyObj->addOppCaricaHasAtto($relObj->copy($deepCopy));
			}

			foreach($this->getOppCaricaHasGruppos() as $relObj) {
				$copyObj->addOppCaricaHasGruppo($relObj->copy($deepCopy));
			}

			foreach($this->getOppVotazioneHasCaricas() as $relObj) {
				$copyObj->addOppVotazioneHasCarica($relObj->copy($deepCopy));
			}

		} 

		$copyObj->setNew(true);

		$copyObj->setId(NULL); 
		$copyObj->setPoliticoId(NULL); 
	}

	
	public function copy($deepCopy = false)
	{
				$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new OppCaricaPeer();
		}
		return self::$peer;
	}

	
	public function setOppPolitico($v)
	{


		if ($v === null) {
			$this->setPoliticoId(NULL);
		} else {
			$this->setPoliticoId($v->getId());
		}


		$this->aOppPolitico = $v;
	}


	
	public function getOppPolitico($con = null)
	{
				include_once 'lib/model/om/BaseOppPoliticoPeer.php';

		if ($this->aOppPolitico === null && ($this->politico_id !== null)) {

			$this->aOppPolitico = OppPoliticoPeer::retrieveByPK($this->politico_id, $con);

			
		}
		return $this->aOppPolitico;
	}

	
	public function initOppAppoggios()
	{
		if ($this->collOppAppoggios === null) {
			$this->collOppAppoggios = array();
		}
	}

	
	public function getOppAppoggios($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppAppoggioPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppAppoggios === null) {
			if ($this->isNew()) {
			   $this->collOppAppoggios = array();
			} else {

				$criteria->add(OppAppoggioPeer::CARICA_ID, $this->getId());

				OppAppoggioPeer::addSelectColumns($criteria);
				$this->collOppAppoggios = OppAppoggioPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(OppAppoggioPeer::CARICA_ID, $this->getId());

				OppAppoggioPeer::addSelectColumns($criteria);
				if (!isset($this->lastOppAppoggioCriteria) || !$this->lastOppAppoggioCriteria->equals($criteria)) {
					$this->collOppAppoggios = OppAppoggioPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastOppAppoggioCriteria = $criteria;
		return $this->collOppAppoggios;
	}

	
	public function countOppAppoggios($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseOppAppoggioPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(OppAppoggioPeer::CARICA_ID, $this->getId());

		return OppAppoggioPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addOppAppoggio(OppAppoggio $l)
	{
		$this->collOppAppoggios[] = $l;
		$l->setOppCarica($this);
	}

	
	public function initOppCaricaHasAttos()
	{
		if ($this->collOppCaricaHasAttos === null) {
			$this->collOppCaricaHasAttos = array();
		}
	}

	
	public function getOppCaricaHasAttos($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppCaricaHasAttoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppCaricaHasAttos === null) {
			if ($this->isNew()) {
			   $this->collOppCaricaHasAttos = array();
			} else {

				$criteria->add(OppCaricaHasAttoPeer::CARICA_ID, $this->getId());

				OppCaricaHasAttoPeer::addSelectColumns($criteria);
				$this->collOppCaricaHasAttos = OppCaricaHasAttoPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(OppCaricaHasAttoPeer::CARICA_ID, $this->getId());

				OppCaricaHasAttoPeer::addSelectColumns($criteria);
				if (!isset($this->lastOppCaricaHasAttoCriteria) || !$this->lastOppCaricaHasAttoCriteria->equals($criteria)) {
					$this->collOppCaricaHasAttos = OppCaricaHasAttoPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastOppCaricaHasAttoCriteria = $criteria;
		return $this->collOppCaricaHasAttos;
	}

	
	public function countOppCaricaHasAttos($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseOppCaricaHasAttoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(OppCaricaHasAttoPeer::CARICA_ID, $this->getId());

		return OppCaricaHasAttoPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addOppCaricaHasAtto(OppCaricaHasAtto $l)
	{
		$this->collOppCaricaHasAttos[] = $l;
		$l->setOppCarica($this);
	}


	
	public function getOppCaricaHasAttosJoinOppAtto($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppCaricaHasAttoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppCaricaHasAttos === null) {
			if ($this->isNew()) {
				$this->collOppCaricaHasAttos = array();
			} else {

				$criteria->add(OppCaricaHasAttoPeer::CARICA_ID, $this->getId());

				$this->collOppCaricaHasAttos = OppCaricaHasAttoPeer::doSelectJoinOppAtto($criteria, $con);
			}
		} else {
									
			$criteria->add(OppCaricaHasAttoPeer::CARICA_ID, $this->getId());

			if (!isset($this->lastOppCaricaHasAttoCriteria) || !$this->lastOppCaricaHasAttoCriteria->equals($criteria)) {
				$this->collOppCaricaHasAttos = OppCaricaHasAttoPeer::doSelectJoinOppAtto($criteria, $con);
			}
		}
		$this->lastOppCaricaHasAttoCriteria = $criteria;

		return $this->collOppCaricaHasAttos;
	}

	
	public function initOppCaricaHasGruppos()
	{
		if ($this->collOppCaricaHasGruppos === null) {
			$this->collOppCaricaHasGruppos = array();
		}
	}

	
	public function getOppCaricaHasGruppos($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppCaricaHasGruppoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppCaricaHasGruppos === null) {
			if ($this->isNew()) {
			   $this->collOppCaricaHasGruppos = array();
			} else {

				$criteria->add(OppCaricaHasGruppoPeer::CARICA_ID, $this->getId());

				OppCaricaHasGruppoPeer::addSelectColumns($criteria);
				$this->collOppCaricaHasGruppos = OppCaricaHasGruppoPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(OppCaricaHasGruppoPeer::CARICA_ID, $this->getId());

				OppCaricaHasGruppoPeer::addSelectColumns($criteria);
				if (!isset($this->lastOppCaricaHasGruppoCriteria) || !$this->lastOppCaricaHasGruppoCriteria->equals($criteria)) {
					$this->collOppCaricaHasGruppos = OppCaricaHasGruppoPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastOppCaricaHasGruppoCriteria = $criteria;
		return $this->collOppCaricaHasGruppos;
	}

	
	public function countOppCaricaHasGruppos($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseOppCaricaHasGruppoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(OppCaricaHasGruppoPeer::CARICA_ID, $this->getId());

		return OppCaricaHasGruppoPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addOppCaricaHasGruppo(OppCaricaHasGruppo $l)
	{
		$this->collOppCaricaHasGruppos[] = $l;
		$l->setOppCarica($this);
	}


	
	public function getOppCaricaHasGrupposJoinOppGruppo($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppCaricaHasGruppoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppCaricaHasGruppos === null) {
			if ($this->isNew()) {
				$this->collOppCaricaHasGruppos = array();
			} else {

				$criteria->add(OppCaricaHasGruppoPeer::CARICA_ID, $this->getId());

				$this->collOppCaricaHasGruppos = OppCaricaHasGruppoPeer::doSelectJoinOppGruppo($criteria, $con);
			}
		} else {
									
			$criteria->add(OppCaricaHasGruppoPeer::CARICA_ID, $this->getId());

			if (!isset($this->lastOppCaricaHasGruppoCriteria) || !$this->lastOppCaricaHasGruppoCriteria->equals($criteria)) {
				$this->collOppCaricaHasGruppos = OppCaricaHasGruppoPeer::doSelectJoinOppGruppo($criteria, $con);
			}
		}
		$this->lastOppCaricaHasGruppoCriteria = $criteria;

		return $this->collOppCaricaHasGruppos;
	}

	
	public function initOppVotazioneHasCaricas()
	{
		if ($this->collOppVotazioneHasCaricas === null) {
			$this->collOppVotazioneHasCaricas = array();
		}
	}

	
	public function getOppVotazioneHasCaricas($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppVotazioneHasCaricaPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppVotazioneHasCaricas === null) {
			if ($this->isNew()) {
			   $this->collOppVotazioneHasCaricas = array();
			} else {

				$criteria->add(OppVotazioneHasCaricaPeer::CARICA_ID, $this->getId());

				OppVotazioneHasCaricaPeer::addSelectColumns($criteria);
				$this->collOppVotazioneHasCaricas = OppVotazioneHasCaricaPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(OppVotazioneHasCaricaPeer::CARICA_ID, $this->getId());

				OppVotazioneHasCaricaPeer::addSelectColumns($criteria);
				if (!isset($this->lastOppVotazioneHasCaricaCriteria) || !$this->lastOppVotazioneHasCaricaCriteria->equals($criteria)) {
					$this->collOppVotazioneHasCaricas = OppVotazioneHasCaricaPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastOppVotazioneHasCaricaCriteria = $criteria;
		return $this->collOppVotazioneHasCaricas;
	}

	
	public function countOppVotazioneHasCaricas($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseOppVotazioneHasCaricaPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(OppVotazioneHasCaricaPeer::CARICA_ID, $this->getId());

		return OppVotazioneHasCaricaPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addOppVotazioneHasCarica(OppVotazioneHasCarica $l)
	{
		$this->collOppVotazioneHasCaricas[] = $l;
		$l->setOppCarica($this);
	}


	
	public function getOppVotazioneHasCaricasJoinOppVotazione($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppVotazioneHasCaricaPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppVotazioneHasCaricas === null) {
			if ($this->isNew()) {
				$this->collOppVotazioneHasCaricas = array();
			} else {

				$criteria->add(OppVotazioneHasCaricaPeer::CARICA_ID, $this->getId());

				$this->collOppVotazioneHasCaricas = OppVotazioneHasCaricaPeer::doSelectJoinOppVotazione($criteria, $con);
			}
		} else {
									
			$criteria->add(OppVotazioneHasCaricaPeer::CARICA_ID, $this->getId());

			if (!isset($this->lastOppVotazioneHasCaricaCriteria) || !$this->lastOppVotazioneHasCaricaCriteria->equals($criteria)) {
				$this->collOppVotazioneHasCaricas = OppVotazioneHasCaricaPeer::doSelectJoinOppVotazione($criteria, $con);
			}
		}
		$this->lastOppVotazioneHasCaricaCriteria = $criteria;

		return $this->collOppVotazioneHasCaricas;
	}

} 