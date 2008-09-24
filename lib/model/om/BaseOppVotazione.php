<?php


abstract class BaseOppVotazione extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $seduta_id;


	
	protected $numero_votazione;


	
	protected $titolo;


	
	protected $presenti;


	
	protected $votanti;


	
	protected $maggioranza;


	
	protected $astenuti;


	
	protected $favorevoli;


	
	protected $contrari;


	
	protected $esito;


	
	protected $ribelli;


	
	protected $margine;


	
	protected $tipologia;


	
	protected $descrizione;


	
	protected $url;


	
	protected $finale = 0;

	
	protected $aOppSeduta;

	
	protected $collOppPolicyHasVotaziones;

	
	protected $lastOppPolicyHasVotazioneCriteria = null;

	
	protected $collOppVotazioneHasAttos;

	
	protected $lastOppVotazioneHasAttoCriteria = null;

	
	protected $collOppVotazioneHasCaricas;

	
	protected $lastOppVotazioneHasCaricaCriteria = null;

	
	protected $collOppVotazioneHasGruppos;

	
	protected $lastOppVotazioneHasGruppoCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getSedutaId()
	{

		return $this->seduta_id;
	}

	
	public function getNumeroVotazione()
	{

		return $this->numero_votazione;
	}

	
	public function getTitolo()
	{

		return $this->titolo;
	}

	
	public function getPresenti()
	{

		return $this->presenti;
	}

	
	public function getVotanti()
	{

		return $this->votanti;
	}

	
	public function getMaggioranza()
	{

		return $this->maggioranza;
	}

	
	public function getAstenuti()
	{

		return $this->astenuti;
	}

	
	public function getFavorevoli()
	{

		return $this->favorevoli;
	}

	
	public function getContrari()
	{

		return $this->contrari;
	}

	
	public function getEsito()
	{

		return $this->esito;
	}

	
	public function getRibelli()
	{

		return $this->ribelli;
	}

	
	public function getMargine()
	{

		return $this->margine;
	}

	
	public function getTipologia()
	{

		return $this->tipologia;
	}

	
	public function getDescrizione()
	{

		return $this->descrizione;
	}

	
	public function getUrl()
	{

		return $this->url;
	}

	
	public function getFinale()
	{

		return $this->finale;
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = OppVotazionePeer::ID;
		}

	} 
	
	public function setSedutaId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->seduta_id !== $v) {
			$this->seduta_id = $v;
			$this->modifiedColumns[] = OppVotazionePeer::SEDUTA_ID;
		}

		if ($this->aOppSeduta !== null && $this->aOppSeduta->getId() !== $v) {
			$this->aOppSeduta = null;
		}

	} 
	
	public function setNumeroVotazione($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->numero_votazione !== $v) {
			$this->numero_votazione = $v;
			$this->modifiedColumns[] = OppVotazionePeer::NUMERO_VOTAZIONE;
		}

	} 
	
	public function setTitolo($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->titolo !== $v) {
			$this->titolo = $v;
			$this->modifiedColumns[] = OppVotazionePeer::TITOLO;
		}

	} 
	
	public function setPresenti($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->presenti !== $v) {
			$this->presenti = $v;
			$this->modifiedColumns[] = OppVotazionePeer::PRESENTI;
		}

	} 
	
	public function setVotanti($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->votanti !== $v) {
			$this->votanti = $v;
			$this->modifiedColumns[] = OppVotazionePeer::VOTANTI;
		}

	} 
	
	public function setMaggioranza($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->maggioranza !== $v) {
			$this->maggioranza = $v;
			$this->modifiedColumns[] = OppVotazionePeer::MAGGIORANZA;
		}

	} 
	
	public function setAstenuti($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->astenuti !== $v) {
			$this->astenuti = $v;
			$this->modifiedColumns[] = OppVotazionePeer::ASTENUTI;
		}

	} 
	
	public function setFavorevoli($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->favorevoli !== $v) {
			$this->favorevoli = $v;
			$this->modifiedColumns[] = OppVotazionePeer::FAVOREVOLI;
		}

	} 
	
	public function setContrari($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->contrari !== $v) {
			$this->contrari = $v;
			$this->modifiedColumns[] = OppVotazionePeer::CONTRARI;
		}

	} 
	
	public function setEsito($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->esito !== $v) {
			$this->esito = $v;
			$this->modifiedColumns[] = OppVotazionePeer::ESITO;
		}

	} 
	
	public function setRibelli($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->ribelli !== $v) {
			$this->ribelli = $v;
			$this->modifiedColumns[] = OppVotazionePeer::RIBELLI;
		}

	} 
	
	public function setMargine($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->margine !== $v) {
			$this->margine = $v;
			$this->modifiedColumns[] = OppVotazionePeer::MARGINE;
		}

	} 
	
	public function setTipologia($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->tipologia !== $v) {
			$this->tipologia = $v;
			$this->modifiedColumns[] = OppVotazionePeer::TIPOLOGIA;
		}

	} 
	
	public function setDescrizione($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->descrizione !== $v) {
			$this->descrizione = $v;
			$this->modifiedColumns[] = OppVotazionePeer::DESCRIZIONE;
		}

	} 
	
	public function setUrl($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->url !== $v) {
			$this->url = $v;
			$this->modifiedColumns[] = OppVotazionePeer::URL;
		}

	} 
	
	public function setFinale($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->finale !== $v || $v === 0) {
			$this->finale = $v;
			$this->modifiedColumns[] = OppVotazionePeer::FINALE;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->seduta_id = $rs->getInt($startcol + 1);

			$this->numero_votazione = $rs->getInt($startcol + 2);

			$this->titolo = $rs->getString($startcol + 3);

			$this->presenti = $rs->getInt($startcol + 4);

			$this->votanti = $rs->getInt($startcol + 5);

			$this->maggioranza = $rs->getInt($startcol + 6);

			$this->astenuti = $rs->getInt($startcol + 7);

			$this->favorevoli = $rs->getInt($startcol + 8);

			$this->contrari = $rs->getInt($startcol + 9);

			$this->esito = $rs->getString($startcol + 10);

			$this->ribelli = $rs->getInt($startcol + 11);

			$this->margine = $rs->getInt($startcol + 12);

			$this->tipologia = $rs->getString($startcol + 13);

			$this->descrizione = $rs->getString($startcol + 14);

			$this->url = $rs->getString($startcol + 15);

			$this->finale = $rs->getInt($startcol + 16);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 17; 
		} catch (Exception $e) {
			throw new PropelException("Error populating OppVotazione object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(OppVotazionePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			OppVotazionePeer::doDelete($this, $con);
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
			$con = Propel::getConnection(OppVotazionePeer::DATABASE_NAME);
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


												
			if ($this->aOppSeduta !== null) {
				if ($this->aOppSeduta->isModified()) {
					$affectedRows += $this->aOppSeduta->save($con);
				}
				$this->setOppSeduta($this->aOppSeduta);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = OppVotazionePeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += OppVotazionePeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collOppPolicyHasVotaziones !== null) {
				foreach($this->collOppPolicyHasVotaziones as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collOppVotazioneHasAttos !== null) {
				foreach($this->collOppVotazioneHasAttos as $referrerFK) {
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

			if ($this->collOppVotazioneHasGruppos !== null) {
				foreach($this->collOppVotazioneHasGruppos as $referrerFK) {
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


												
			if ($this->aOppSeduta !== null) {
				if (!$this->aOppSeduta->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOppSeduta->getValidationFailures());
				}
			}


			if (($retval = OppVotazionePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collOppPolicyHasVotaziones !== null) {
					foreach($this->collOppPolicyHasVotaziones as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collOppVotazioneHasAttos !== null) {
					foreach($this->collOppVotazioneHasAttos as $referrerFK) {
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

				if ($this->collOppVotazioneHasGruppos !== null) {
					foreach($this->collOppVotazioneHasGruppos as $referrerFK) {
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
		$pos = OppVotazionePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getSedutaId();
				break;
			case 2:
				return $this->getNumeroVotazione();
				break;
			case 3:
				return $this->getTitolo();
				break;
			case 4:
				return $this->getPresenti();
				break;
			case 5:
				return $this->getVotanti();
				break;
			case 6:
				return $this->getMaggioranza();
				break;
			case 7:
				return $this->getAstenuti();
				break;
			case 8:
				return $this->getFavorevoli();
				break;
			case 9:
				return $this->getContrari();
				break;
			case 10:
				return $this->getEsito();
				break;
			case 11:
				return $this->getRibelli();
				break;
			case 12:
				return $this->getMargine();
				break;
			case 13:
				return $this->getTipologia();
				break;
			case 14:
				return $this->getDescrizione();
				break;
			case 15:
				return $this->getUrl();
				break;
			case 16:
				return $this->getFinale();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppVotazionePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getSedutaId(),
			$keys[2] => $this->getNumeroVotazione(),
			$keys[3] => $this->getTitolo(),
			$keys[4] => $this->getPresenti(),
			$keys[5] => $this->getVotanti(),
			$keys[6] => $this->getMaggioranza(),
			$keys[7] => $this->getAstenuti(),
			$keys[8] => $this->getFavorevoli(),
			$keys[9] => $this->getContrari(),
			$keys[10] => $this->getEsito(),
			$keys[11] => $this->getRibelli(),
			$keys[12] => $this->getMargine(),
			$keys[13] => $this->getTipologia(),
			$keys[14] => $this->getDescrizione(),
			$keys[15] => $this->getUrl(),
			$keys[16] => $this->getFinale(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppVotazionePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setSedutaId($value);
				break;
			case 2:
				$this->setNumeroVotazione($value);
				break;
			case 3:
				$this->setTitolo($value);
				break;
			case 4:
				$this->setPresenti($value);
				break;
			case 5:
				$this->setVotanti($value);
				break;
			case 6:
				$this->setMaggioranza($value);
				break;
			case 7:
				$this->setAstenuti($value);
				break;
			case 8:
				$this->setFavorevoli($value);
				break;
			case 9:
				$this->setContrari($value);
				break;
			case 10:
				$this->setEsito($value);
				break;
			case 11:
				$this->setRibelli($value);
				break;
			case 12:
				$this->setMargine($value);
				break;
			case 13:
				$this->setTipologia($value);
				break;
			case 14:
				$this->setDescrizione($value);
				break;
			case 15:
				$this->setUrl($value);
				break;
			case 16:
				$this->setFinale($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppVotazionePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setSedutaId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setNumeroVotazione($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setTitolo($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setPresenti($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setVotanti($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setMaggioranza($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setAstenuti($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setFavorevoli($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setContrari($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setEsito($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setRibelli($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setMargine($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setTipologia($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setDescrizione($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setUrl($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setFinale($arr[$keys[16]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(OppVotazionePeer::DATABASE_NAME);

		if ($this->isColumnModified(OppVotazionePeer::ID)) $criteria->add(OppVotazionePeer::ID, $this->id);
		if ($this->isColumnModified(OppVotazionePeer::SEDUTA_ID)) $criteria->add(OppVotazionePeer::SEDUTA_ID, $this->seduta_id);
		if ($this->isColumnModified(OppVotazionePeer::NUMERO_VOTAZIONE)) $criteria->add(OppVotazionePeer::NUMERO_VOTAZIONE, $this->numero_votazione);
		if ($this->isColumnModified(OppVotazionePeer::TITOLO)) $criteria->add(OppVotazionePeer::TITOLO, $this->titolo);
		if ($this->isColumnModified(OppVotazionePeer::PRESENTI)) $criteria->add(OppVotazionePeer::PRESENTI, $this->presenti);
		if ($this->isColumnModified(OppVotazionePeer::VOTANTI)) $criteria->add(OppVotazionePeer::VOTANTI, $this->votanti);
		if ($this->isColumnModified(OppVotazionePeer::MAGGIORANZA)) $criteria->add(OppVotazionePeer::MAGGIORANZA, $this->maggioranza);
		if ($this->isColumnModified(OppVotazionePeer::ASTENUTI)) $criteria->add(OppVotazionePeer::ASTENUTI, $this->astenuti);
		if ($this->isColumnModified(OppVotazionePeer::FAVOREVOLI)) $criteria->add(OppVotazionePeer::FAVOREVOLI, $this->favorevoli);
		if ($this->isColumnModified(OppVotazionePeer::CONTRARI)) $criteria->add(OppVotazionePeer::CONTRARI, $this->contrari);
		if ($this->isColumnModified(OppVotazionePeer::ESITO)) $criteria->add(OppVotazionePeer::ESITO, $this->esito);
		if ($this->isColumnModified(OppVotazionePeer::RIBELLI)) $criteria->add(OppVotazionePeer::RIBELLI, $this->ribelli);
		if ($this->isColumnModified(OppVotazionePeer::MARGINE)) $criteria->add(OppVotazionePeer::MARGINE, $this->margine);
		if ($this->isColumnModified(OppVotazionePeer::TIPOLOGIA)) $criteria->add(OppVotazionePeer::TIPOLOGIA, $this->tipologia);
		if ($this->isColumnModified(OppVotazionePeer::DESCRIZIONE)) $criteria->add(OppVotazionePeer::DESCRIZIONE, $this->descrizione);
		if ($this->isColumnModified(OppVotazionePeer::URL)) $criteria->add(OppVotazionePeer::URL, $this->url);
		if ($this->isColumnModified(OppVotazionePeer::FINALE)) $criteria->add(OppVotazionePeer::FINALE, $this->finale);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(OppVotazionePeer::DATABASE_NAME);

		$criteria->add(OppVotazionePeer::ID, $this->id);
		$criteria->add(OppVotazionePeer::SEDUTA_ID, $this->seduta_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getId();

		$pks[1] = $this->getSedutaId();

		return $pks;
	}

	
	public function setPrimaryKey($keys)
	{

		$this->setId($keys[0]);

		$this->setSedutaId($keys[1]);

	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setNumeroVotazione($this->numero_votazione);

		$copyObj->setTitolo($this->titolo);

		$copyObj->setPresenti($this->presenti);

		$copyObj->setVotanti($this->votanti);

		$copyObj->setMaggioranza($this->maggioranza);

		$copyObj->setAstenuti($this->astenuti);

		$copyObj->setFavorevoli($this->favorevoli);

		$copyObj->setContrari($this->contrari);

		$copyObj->setEsito($this->esito);

		$copyObj->setRibelli($this->ribelli);

		$copyObj->setMargine($this->margine);

		$copyObj->setTipologia($this->tipologia);

		$copyObj->setDescrizione($this->descrizione);

		$copyObj->setUrl($this->url);

		$copyObj->setFinale($this->finale);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getOppPolicyHasVotaziones() as $relObj) {
				$copyObj->addOppPolicyHasVotazione($relObj->copy($deepCopy));
			}

			foreach($this->getOppVotazioneHasAttos() as $relObj) {
				$copyObj->addOppVotazioneHasAtto($relObj->copy($deepCopy));
			}

			foreach($this->getOppVotazioneHasCaricas() as $relObj) {
				$copyObj->addOppVotazioneHasCarica($relObj->copy($deepCopy));
			}

			foreach($this->getOppVotazioneHasGruppos() as $relObj) {
				$copyObj->addOppVotazioneHasGruppo($relObj->copy($deepCopy));
			}

		} 

		$copyObj->setNew(true);

		$copyObj->setId(NULL); 
		$copyObj->setSedutaId(NULL); 
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
			self::$peer = new OppVotazionePeer();
		}
		return self::$peer;
	}

	
	public function setOppSeduta($v)
	{


		if ($v === null) {
			$this->setSedutaId(NULL);
		} else {
			$this->setSedutaId($v->getId());
		}


		$this->aOppSeduta = $v;
	}


	
	public function getOppSeduta($con = null)
	{
				include_once 'lib/model/om/BaseOppSedutaPeer.php';

		if ($this->aOppSeduta === null && ($this->seduta_id !== null)) {

			$this->aOppSeduta = OppSedutaPeer::retrieveByPK($this->seduta_id, $con);

			
		}
		return $this->aOppSeduta;
	}

	
	public function initOppPolicyHasVotaziones()
	{
		if ($this->collOppPolicyHasVotaziones === null) {
			$this->collOppPolicyHasVotaziones = array();
		}
	}

	
	public function getOppPolicyHasVotaziones($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppPolicyHasVotazionePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppPolicyHasVotaziones === null) {
			if ($this->isNew()) {
			   $this->collOppPolicyHasVotaziones = array();
			} else {

				$criteria->add(OppPolicyHasVotazionePeer::VOTAZIONE_ID, $this->getId());

				OppPolicyHasVotazionePeer::addSelectColumns($criteria);
				$this->collOppPolicyHasVotaziones = OppPolicyHasVotazionePeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(OppPolicyHasVotazionePeer::VOTAZIONE_ID, $this->getId());

				OppPolicyHasVotazionePeer::addSelectColumns($criteria);
				if (!isset($this->lastOppPolicyHasVotazioneCriteria) || !$this->lastOppPolicyHasVotazioneCriteria->equals($criteria)) {
					$this->collOppPolicyHasVotaziones = OppPolicyHasVotazionePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastOppPolicyHasVotazioneCriteria = $criteria;
		return $this->collOppPolicyHasVotaziones;
	}

	
	public function countOppPolicyHasVotaziones($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseOppPolicyHasVotazionePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(OppPolicyHasVotazionePeer::VOTAZIONE_ID, $this->getId());

		return OppPolicyHasVotazionePeer::doCount($criteria, $distinct, $con);
	}

	
	public function addOppPolicyHasVotazione(OppPolicyHasVotazione $l)
	{
		$this->collOppPolicyHasVotaziones[] = $l;
		$l->setOppVotazione($this);
	}


	
	public function getOppPolicyHasVotazionesJoinOppPolicy($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppPolicyHasVotazionePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppPolicyHasVotaziones === null) {
			if ($this->isNew()) {
				$this->collOppPolicyHasVotaziones = array();
			} else {

				$criteria->add(OppPolicyHasVotazionePeer::VOTAZIONE_ID, $this->getId());

				$this->collOppPolicyHasVotaziones = OppPolicyHasVotazionePeer::doSelectJoinOppPolicy($criteria, $con);
			}
		} else {
									
			$criteria->add(OppPolicyHasVotazionePeer::VOTAZIONE_ID, $this->getId());

			if (!isset($this->lastOppPolicyHasVotazioneCriteria) || !$this->lastOppPolicyHasVotazioneCriteria->equals($criteria)) {
				$this->collOppPolicyHasVotaziones = OppPolicyHasVotazionePeer::doSelectJoinOppPolicy($criteria, $con);
			}
		}
		$this->lastOppPolicyHasVotazioneCriteria = $criteria;

		return $this->collOppPolicyHasVotaziones;
	}

	
	public function initOppVotazioneHasAttos()
	{
		if ($this->collOppVotazioneHasAttos === null) {
			$this->collOppVotazioneHasAttos = array();
		}
	}

	
	public function getOppVotazioneHasAttos($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppVotazioneHasAttoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppVotazioneHasAttos === null) {
			if ($this->isNew()) {
			   $this->collOppVotazioneHasAttos = array();
			} else {

				$criteria->add(OppVotazioneHasAttoPeer::VOTAZIONE_ID, $this->getId());

				OppVotazioneHasAttoPeer::addSelectColumns($criteria);
				$this->collOppVotazioneHasAttos = OppVotazioneHasAttoPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(OppVotazioneHasAttoPeer::VOTAZIONE_ID, $this->getId());

				OppVotazioneHasAttoPeer::addSelectColumns($criteria);
				if (!isset($this->lastOppVotazioneHasAttoCriteria) || !$this->lastOppVotazioneHasAttoCriteria->equals($criteria)) {
					$this->collOppVotazioneHasAttos = OppVotazioneHasAttoPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastOppVotazioneHasAttoCriteria = $criteria;
		return $this->collOppVotazioneHasAttos;
	}

	
	public function countOppVotazioneHasAttos($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseOppVotazioneHasAttoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(OppVotazioneHasAttoPeer::VOTAZIONE_ID, $this->getId());

		return OppVotazioneHasAttoPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addOppVotazioneHasAtto(OppVotazioneHasAtto $l)
	{
		$this->collOppVotazioneHasAttos[] = $l;
		$l->setOppVotazione($this);
	}


	
	public function getOppVotazioneHasAttosJoinOppAtto($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppVotazioneHasAttoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppVotazioneHasAttos === null) {
			if ($this->isNew()) {
				$this->collOppVotazioneHasAttos = array();
			} else {

				$criteria->add(OppVotazioneHasAttoPeer::VOTAZIONE_ID, $this->getId());

				$this->collOppVotazioneHasAttos = OppVotazioneHasAttoPeer::doSelectJoinOppAtto($criteria, $con);
			}
		} else {
									
			$criteria->add(OppVotazioneHasAttoPeer::VOTAZIONE_ID, $this->getId());

			if (!isset($this->lastOppVotazioneHasAttoCriteria) || !$this->lastOppVotazioneHasAttoCriteria->equals($criteria)) {
				$this->collOppVotazioneHasAttos = OppVotazioneHasAttoPeer::doSelectJoinOppAtto($criteria, $con);
			}
		}
		$this->lastOppVotazioneHasAttoCriteria = $criteria;

		return $this->collOppVotazioneHasAttos;
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

				$criteria->add(OppVotazioneHasCaricaPeer::VOTAZIONE_ID, $this->getId());

				OppVotazioneHasCaricaPeer::addSelectColumns($criteria);
				$this->collOppVotazioneHasCaricas = OppVotazioneHasCaricaPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(OppVotazioneHasCaricaPeer::VOTAZIONE_ID, $this->getId());

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

		$criteria->add(OppVotazioneHasCaricaPeer::VOTAZIONE_ID, $this->getId());

		return OppVotazioneHasCaricaPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addOppVotazioneHasCarica(OppVotazioneHasCarica $l)
	{
		$this->collOppVotazioneHasCaricas[] = $l;
		$l->setOppVotazione($this);
	}


	
	public function getOppVotazioneHasCaricasJoinOppCarica($criteria = null, $con = null)
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

				$criteria->add(OppVotazioneHasCaricaPeer::VOTAZIONE_ID, $this->getId());

				$this->collOppVotazioneHasCaricas = OppVotazioneHasCaricaPeer::doSelectJoinOppCarica($criteria, $con);
			}
		} else {
									
			$criteria->add(OppVotazioneHasCaricaPeer::VOTAZIONE_ID, $this->getId());

			if (!isset($this->lastOppVotazioneHasCaricaCriteria) || !$this->lastOppVotazioneHasCaricaCriteria->equals($criteria)) {
				$this->collOppVotazioneHasCaricas = OppVotazioneHasCaricaPeer::doSelectJoinOppCarica($criteria, $con);
			}
		}
		$this->lastOppVotazioneHasCaricaCriteria = $criteria;

		return $this->collOppVotazioneHasCaricas;
	}

	
	public function initOppVotazioneHasGruppos()
	{
		if ($this->collOppVotazioneHasGruppos === null) {
			$this->collOppVotazioneHasGruppos = array();
		}
	}

	
	public function getOppVotazioneHasGruppos($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppVotazioneHasGruppoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppVotazioneHasGruppos === null) {
			if ($this->isNew()) {
			   $this->collOppVotazioneHasGruppos = array();
			} else {

				$criteria->add(OppVotazioneHasGruppoPeer::VOTAZIONE_ID, $this->getId());

				OppVotazioneHasGruppoPeer::addSelectColumns($criteria);
				$this->collOppVotazioneHasGruppos = OppVotazioneHasGruppoPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(OppVotazioneHasGruppoPeer::VOTAZIONE_ID, $this->getId());

				OppVotazioneHasGruppoPeer::addSelectColumns($criteria);
				if (!isset($this->lastOppVotazioneHasGruppoCriteria) || !$this->lastOppVotazioneHasGruppoCriteria->equals($criteria)) {
					$this->collOppVotazioneHasGruppos = OppVotazioneHasGruppoPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastOppVotazioneHasGruppoCriteria = $criteria;
		return $this->collOppVotazioneHasGruppos;
	}

	
	public function countOppVotazioneHasGruppos($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseOppVotazioneHasGruppoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(OppVotazioneHasGruppoPeer::VOTAZIONE_ID, $this->getId());

		return OppVotazioneHasGruppoPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addOppVotazioneHasGruppo(OppVotazioneHasGruppo $l)
	{
		$this->collOppVotazioneHasGruppos[] = $l;
		$l->setOppVotazione($this);
	}


	
	public function getOppVotazioneHasGrupposJoinOppGruppo($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppVotazioneHasGruppoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppVotazioneHasGruppos === null) {
			if ($this->isNew()) {
				$this->collOppVotazioneHasGruppos = array();
			} else {

				$criteria->add(OppVotazioneHasGruppoPeer::VOTAZIONE_ID, $this->getId());

				$this->collOppVotazioneHasGruppos = OppVotazioneHasGruppoPeer::doSelectJoinOppGruppo($criteria, $con);
			}
		} else {
									
			$criteria->add(OppVotazioneHasGruppoPeer::VOTAZIONE_ID, $this->getId());

			if (!isset($this->lastOppVotazioneHasGruppoCriteria) || !$this->lastOppVotazioneHasGruppoCriteria->equals($criteria)) {
				$this->collOppVotazioneHasGruppos = OppVotazioneHasGruppoPeer::doSelectJoinOppGruppo($criteria, $con);
			}
		}
		$this->lastOppVotazioneHasGruppoCriteria = $criteria;

		return $this->collOppVotazioneHasGruppos;
	}

} 