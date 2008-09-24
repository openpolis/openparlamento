<?php


abstract class BaseOppCarica extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $politico_id;


	
	protected $tipo_carica_id;


	
	protected $carica;


	
	protected $data_inizio;


	
	protected $data_fine;


	
	protected $legislatura;


	
	protected $circoscrizione;


	
	protected $presenze;


	
	protected $assenze;


	
	protected $missioni;


	
	protected $parliament_id;


	
	protected $indice;


	
	protected $scaglione;


	
	protected $posizione;


	
	protected $media;

	
	protected $aOppPolitico;

	
	protected $aOppTipoCarica;

	
	protected $collOppAppoggios;

	
	protected $lastOppAppoggioCriteria = null;

	
	protected $collOppCaricaHasAttos;

	
	protected $lastOppCaricaHasAttoCriteria = null;

	
	protected $collOppCaricaHasGruppos;

	
	protected $lastOppCaricaHasGruppoCriteria = null;

	
	protected $collOppInterventos;

	
	protected $lastOppInterventoCriteria = null;

	
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

	
	public function getTipoCaricaId()
	{

		return $this->tipo_carica_id;
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
	
	public function setTipoCaricaId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->tipo_carica_id !== $v) {
			$this->tipo_carica_id = $v;
			$this->modifiedColumns[] = OppCaricaPeer::TIPO_CARICA_ID;
		}

		if ($this->aOppTipoCarica !== null && $this->aOppTipoCarica->getId() !== $v) {
			$this->aOppTipoCarica = null;
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

			$this->tipo_carica_id = $rs->getInt($startcol + 2);

			$this->carica = $rs->getString($startcol + 3);

			$this->data_inizio = $rs->getDate($startcol + 4, null);

			$this->data_fine = $rs->getDate($startcol + 5, null);

			$this->legislatura = $rs->getInt($startcol + 6);

			$this->circoscrizione = $rs->getString($startcol + 7);

			$this->presenze = $rs->getInt($startcol + 8);

			$this->assenze = $rs->getInt($startcol + 9);

			$this->missioni = $rs->getInt($startcol + 10);

			$this->parliament_id = $rs->getInt($startcol + 11);

			$this->indice = $rs->getFloat($startcol + 12);

			$this->scaglione = $rs->getInt($startcol + 13);

			$this->posizione = $rs->getInt($startcol + 14);

			$this->media = $rs->getFloat($startcol + 15);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 16; 
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

			if ($this->aOppTipoCarica !== null) {
				if ($this->aOppTipoCarica->isModified()) {
					$affectedRows += $this->aOppTipoCarica->save($con);
				}
				$this->setOppTipoCarica($this->aOppTipoCarica);
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

			if ($this->collOppInterventos !== null) {
				foreach($this->collOppInterventos as $referrerFK) {
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

			if ($this->aOppTipoCarica !== null) {
				if (!$this->aOppTipoCarica->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOppTipoCarica->getValidationFailures());
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

				if ($this->collOppInterventos !== null) {
					foreach($this->collOppInterventos as $referrerFK) {
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
				return $this->getTipoCaricaId();
				break;
			case 3:
				return $this->getCarica();
				break;
			case 4:
				return $this->getDataInizio();
				break;
			case 5:
				return $this->getDataFine();
				break;
			case 6:
				return $this->getLegislatura();
				break;
			case 7:
				return $this->getCircoscrizione();
				break;
			case 8:
				return $this->getPresenze();
				break;
			case 9:
				return $this->getAssenze();
				break;
			case 10:
				return $this->getMissioni();
				break;
			case 11:
				return $this->getParliamentId();
				break;
			case 12:
				return $this->getIndice();
				break;
			case 13:
				return $this->getScaglione();
				break;
			case 14:
				return $this->getPosizione();
				break;
			case 15:
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
			$keys[2] => $this->getTipoCaricaId(),
			$keys[3] => $this->getCarica(),
			$keys[4] => $this->getDataInizio(),
			$keys[5] => $this->getDataFine(),
			$keys[6] => $this->getLegislatura(),
			$keys[7] => $this->getCircoscrizione(),
			$keys[8] => $this->getPresenze(),
			$keys[9] => $this->getAssenze(),
			$keys[10] => $this->getMissioni(),
			$keys[11] => $this->getParliamentId(),
			$keys[12] => $this->getIndice(),
			$keys[13] => $this->getScaglione(),
			$keys[14] => $this->getPosizione(),
			$keys[15] => $this->getMedia(),
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
				$this->setTipoCaricaId($value);
				break;
			case 3:
				$this->setCarica($value);
				break;
			case 4:
				$this->setDataInizio($value);
				break;
			case 5:
				$this->setDataFine($value);
				break;
			case 6:
				$this->setLegislatura($value);
				break;
			case 7:
				$this->setCircoscrizione($value);
				break;
			case 8:
				$this->setPresenze($value);
				break;
			case 9:
				$this->setAssenze($value);
				break;
			case 10:
				$this->setMissioni($value);
				break;
			case 11:
				$this->setParliamentId($value);
				break;
			case 12:
				$this->setIndice($value);
				break;
			case 13:
				$this->setScaglione($value);
				break;
			case 14:
				$this->setPosizione($value);
				break;
			case 15:
				$this->setMedia($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppCaricaPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setPoliticoId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setTipoCaricaId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setCarica($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setDataInizio($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setDataFine($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setLegislatura($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setCircoscrizione($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setPresenze($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setAssenze($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setMissioni($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setParliamentId($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setIndice($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setScaglione($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setPosizione($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setMedia($arr[$keys[15]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(OppCaricaPeer::DATABASE_NAME);

		if ($this->isColumnModified(OppCaricaPeer::ID)) $criteria->add(OppCaricaPeer::ID, $this->id);
		if ($this->isColumnModified(OppCaricaPeer::POLITICO_ID)) $criteria->add(OppCaricaPeer::POLITICO_ID, $this->politico_id);
		if ($this->isColumnModified(OppCaricaPeer::TIPO_CARICA_ID)) $criteria->add(OppCaricaPeer::TIPO_CARICA_ID, $this->tipo_carica_id);
		if ($this->isColumnModified(OppCaricaPeer::CARICA)) $criteria->add(OppCaricaPeer::CARICA, $this->carica);
		if ($this->isColumnModified(OppCaricaPeer::DATA_INIZIO)) $criteria->add(OppCaricaPeer::DATA_INIZIO, $this->data_inizio);
		if ($this->isColumnModified(OppCaricaPeer::DATA_FINE)) $criteria->add(OppCaricaPeer::DATA_FINE, $this->data_fine);
		if ($this->isColumnModified(OppCaricaPeer::LEGISLATURA)) $criteria->add(OppCaricaPeer::LEGISLATURA, $this->legislatura);
		if ($this->isColumnModified(OppCaricaPeer::CIRCOSCRIZIONE)) $criteria->add(OppCaricaPeer::CIRCOSCRIZIONE, $this->circoscrizione);
		if ($this->isColumnModified(OppCaricaPeer::PRESENZE)) $criteria->add(OppCaricaPeer::PRESENZE, $this->presenze);
		if ($this->isColumnModified(OppCaricaPeer::ASSENZE)) $criteria->add(OppCaricaPeer::ASSENZE, $this->assenze);
		if ($this->isColumnModified(OppCaricaPeer::MISSIONI)) $criteria->add(OppCaricaPeer::MISSIONI, $this->missioni);
		if ($this->isColumnModified(OppCaricaPeer::PARLIAMENT_ID)) $criteria->add(OppCaricaPeer::PARLIAMENT_ID, $this->parliament_id);
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
		$criteria->add(OppCaricaPeer::TIPO_CARICA_ID, $this->tipo_carica_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getId();

		$pks[1] = $this->getPoliticoId();

		$pks[2] = $this->getTipoCaricaId();

		return $pks;
	}

	
	public function setPrimaryKey($keys)
	{

		$this->setId($keys[0]);

		$this->setPoliticoId($keys[1]);

		$this->setTipoCaricaId($keys[2]);

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

			foreach($this->getOppInterventos() as $relObj) {
				$copyObj->addOppIntervento($relObj->copy($deepCopy));
			}

			foreach($this->getOppVotazioneHasCaricas() as $relObj) {
				$copyObj->addOppVotazioneHasCarica($relObj->copy($deepCopy));
			}

		} 

		$copyObj->setNew(true);

		$copyObj->setId(NULL); 
		$copyObj->setPoliticoId(NULL); 
		$copyObj->setTipoCaricaId(NULL); 
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

	
	public function setOppTipoCarica($v)
	{


		if ($v === null) {
			$this->setTipoCaricaId(NULL);
		} else {
			$this->setTipoCaricaId($v->getId());
		}


		$this->aOppTipoCarica = $v;
	}


	
	public function getOppTipoCarica($con = null)
	{
				include_once 'lib/model/om/BaseOppTipoCaricaPeer.php';

		if ($this->aOppTipoCarica === null && ($this->tipo_carica_id !== null)) {

			$this->aOppTipoCarica = OppTipoCaricaPeer::retrieveByPK($this->tipo_carica_id, $con);

			
		}
		return $this->aOppTipoCarica;
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

	
	public function initOppInterventos()
	{
		if ($this->collOppInterventos === null) {
			$this->collOppInterventos = array();
		}
	}

	
	public function getOppInterventos($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppInterventoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppInterventos === null) {
			if ($this->isNew()) {
			   $this->collOppInterventos = array();
			} else {

				$criteria->add(OppInterventoPeer::CARICA_ID, $this->getId());

				OppInterventoPeer::addSelectColumns($criteria);
				$this->collOppInterventos = OppInterventoPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(OppInterventoPeer::CARICA_ID, $this->getId());

				OppInterventoPeer::addSelectColumns($criteria);
				if (!isset($this->lastOppInterventoCriteria) || !$this->lastOppInterventoCriteria->equals($criteria)) {
					$this->collOppInterventos = OppInterventoPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastOppInterventoCriteria = $criteria;
		return $this->collOppInterventos;
	}

	
	public function countOppInterventos($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseOppInterventoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(OppInterventoPeer::CARICA_ID, $this->getId());

		return OppInterventoPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addOppIntervento(OppIntervento $l)
	{
		$this->collOppInterventos[] = $l;
		$l->setOppCarica($this);
	}


	
	public function getOppInterventosJoinOppAtto($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppInterventoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppInterventos === null) {
			if ($this->isNew()) {
				$this->collOppInterventos = array();
			} else {

				$criteria->add(OppInterventoPeer::CARICA_ID, $this->getId());

				$this->collOppInterventos = OppInterventoPeer::doSelectJoinOppAtto($criteria, $con);
			}
		} else {
									
			$criteria->add(OppInterventoPeer::CARICA_ID, $this->getId());

			if (!isset($this->lastOppInterventoCriteria) || !$this->lastOppInterventoCriteria->equals($criteria)) {
				$this->collOppInterventos = OppInterventoPeer::doSelectJoinOppAtto($criteria, $con);
			}
		}
		$this->lastOppInterventoCriteria = $criteria;

		return $this->collOppInterventos;
	}


	
	public function getOppInterventosJoinOppSede($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppInterventoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppInterventos === null) {
			if ($this->isNew()) {
				$this->collOppInterventos = array();
			} else {

				$criteria->add(OppInterventoPeer::CARICA_ID, $this->getId());

				$this->collOppInterventos = OppInterventoPeer::doSelectJoinOppSede($criteria, $con);
			}
		} else {
									
			$criteria->add(OppInterventoPeer::CARICA_ID, $this->getId());

			if (!isset($this->lastOppInterventoCriteria) || !$this->lastOppInterventoCriteria->equals($criteria)) {
				$this->collOppInterventos = OppInterventoPeer::doSelectJoinOppSede($criteria, $con);
			}
		}
		$this->lastOppInterventoCriteria = $criteria;

		return $this->collOppInterventos;
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