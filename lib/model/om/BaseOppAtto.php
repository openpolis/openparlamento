<?php


abstract class BaseOppAtto extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $parlamento_id;


	
	protected $tipo_atto_id;


	
	protected $ramo;


	
	protected $numfase;


	
	protected $legislatura;


	
	protected $data_pres;


	
	protected $data_agg;


	
	protected $titolo;


	
	protected $iniziativa;


	
	protected $completo;


	
	protected $descrizione;


	
	protected $seduta;


	
	protected $iter;


	
	protected $data_iter;

	
	protected $aOppTipoAtto;

	
	protected $collOppAttoHasTeseos;

	
	protected $lastOppAttoHasTeseoCriteria = null;

	
	protected $collOppCaricaHasAttos;

	
	protected $lastOppCaricaHasAttoCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getParlamentoId()
	{

		return $this->parlamento_id;
	}

	
	public function getTipoAttoId()
	{

		return $this->tipo_atto_id;
	}

	
	public function getRamo()
	{

		return $this->ramo;
	}

	
	public function getNumfase()
	{

		return $this->numfase;
	}

	
	public function getLegislatura()
	{

		return $this->legislatura;
	}

	
	public function getDataPres($format = 'Y-m-d')
	{

		if ($this->data_pres === null || $this->data_pres === '') {
			return null;
		} elseif (!is_int($this->data_pres)) {
						$ts = strtotime($this->data_pres);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [data_pres] as date/time value: " . var_export($this->data_pres, true));
			}
		} else {
			$ts = $this->data_pres;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getDataAgg($format = 'Y-m-d')
	{

		if ($this->data_agg === null || $this->data_agg === '') {
			return null;
		} elseif (!is_int($this->data_agg)) {
						$ts = strtotime($this->data_agg);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [data_agg] as date/time value: " . var_export($this->data_agg, true));
			}
		} else {
			$ts = $this->data_agg;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getTitolo()
	{

		return $this->titolo;
	}

	
	public function getIniziativa()
	{

		return $this->iniziativa;
	}

	
	public function getCompleto()
	{

		return $this->completo;
	}

	
	public function getDescrizione()
	{

		return $this->descrizione;
	}

	
	public function getSeduta()
	{

		return $this->seduta;
	}

	
	public function getIter()
	{

		return $this->iter;
	}

	
	public function getDataIter($format = 'Y-m-d')
	{

		if ($this->data_iter === null || $this->data_iter === '') {
			return null;
		} elseif (!is_int($this->data_iter)) {
						$ts = strtotime($this->data_iter);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [data_iter] as date/time value: " . var_export($this->data_iter, true));
			}
		} else {
			$ts = $this->data_iter;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = OppAttoPeer::ID;
		}

	} 
	
	public function setParlamentoId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->parlamento_id !== $v) {
			$this->parlamento_id = $v;
			$this->modifiedColumns[] = OppAttoPeer::PARLAMENTO_ID;
		}

	} 
	
	public function setTipoAttoId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->tipo_atto_id !== $v) {
			$this->tipo_atto_id = $v;
			$this->modifiedColumns[] = OppAttoPeer::TIPO_ATTO_ID;
		}

		if ($this->aOppTipoAtto !== null && $this->aOppTipoAtto->getId() !== $v) {
			$this->aOppTipoAtto = null;
		}

	} 
	
	public function setRamo($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->ramo !== $v) {
			$this->ramo = $v;
			$this->modifiedColumns[] = OppAttoPeer::RAMO;
		}

	} 
	
	public function setNumfase($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->numfase !== $v) {
			$this->numfase = $v;
			$this->modifiedColumns[] = OppAttoPeer::NUMFASE;
		}

	} 
	
	public function setLegislatura($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->legislatura !== $v) {
			$this->legislatura = $v;
			$this->modifiedColumns[] = OppAttoPeer::LEGISLATURA;
		}

	} 
	
	public function setDataPres($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [data_pres] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->data_pres !== $ts) {
			$this->data_pres = $ts;
			$this->modifiedColumns[] = OppAttoPeer::DATA_PRES;
		}

	} 
	
	public function setDataAgg($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [data_agg] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->data_agg !== $ts) {
			$this->data_agg = $ts;
			$this->modifiedColumns[] = OppAttoPeer::DATA_AGG;
		}

	} 
	
	public function setTitolo($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->titolo !== $v) {
			$this->titolo = $v;
			$this->modifiedColumns[] = OppAttoPeer::TITOLO;
		}

	} 
	
	public function setIniziativa($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->iniziativa !== $v) {
			$this->iniziativa = $v;
			$this->modifiedColumns[] = OppAttoPeer::INIZIATIVA;
		}

	} 
	
	public function setCompleto($v)
	{

		if ($this->completo !== $v) {
			$this->completo = $v;
			$this->modifiedColumns[] = OppAttoPeer::COMPLETO;
		}

	} 
	
	public function setDescrizione($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->descrizione !== $v) {
			$this->descrizione = $v;
			$this->modifiedColumns[] = OppAttoPeer::DESCRIZIONE;
		}

	} 
	
	public function setSeduta($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->seduta !== $v) {
			$this->seduta = $v;
			$this->modifiedColumns[] = OppAttoPeer::SEDUTA;
		}

	} 
	
	public function setIter($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->iter !== $v) {
			$this->iter = $v;
			$this->modifiedColumns[] = OppAttoPeer::ITER;
		}

	} 
	
	public function setDataIter($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [data_iter] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->data_iter !== $ts) {
			$this->data_iter = $ts;
			$this->modifiedColumns[] = OppAttoPeer::DATA_ITER;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->parlamento_id = $rs->getInt($startcol + 1);

			$this->tipo_atto_id = $rs->getInt($startcol + 2);

			$this->ramo = $rs->getString($startcol + 3);

			$this->numfase = $rs->getInt($startcol + 4);

			$this->legislatura = $rs->getInt($startcol + 5);

			$this->data_pres = $rs->getDate($startcol + 6, null);

			$this->data_agg = $rs->getDate($startcol + 7, null);

			$this->titolo = $rs->getString($startcol + 8);

			$this->iniziativa = $rs->getInt($startcol + 9);

			$this->completo = $rs->getBoolean($startcol + 10);

			$this->descrizione = $rs->getString($startcol + 11);

			$this->seduta = $rs->getInt($startcol + 12);

			$this->iter = $rs->getString($startcol + 13);

			$this->data_iter = $rs->getDate($startcol + 14, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 15; 
		} catch (Exception $e) {
			throw new PropelException("Error populating OppAtto object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(OppAttoPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			OppAttoPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(OppAttoPeer::DATABASE_NAME);
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


												
			if ($this->aOppTipoAtto !== null) {
				if ($this->aOppTipoAtto->isModified()) {
					$affectedRows += $this->aOppTipoAtto->save($con);
				}
				$this->setOppTipoAtto($this->aOppTipoAtto);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = OppAttoPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += OppAttoPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collOppAttoHasTeseos !== null) {
				foreach($this->collOppAttoHasTeseos as $referrerFK) {
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


												
			if ($this->aOppTipoAtto !== null) {
				if (!$this->aOppTipoAtto->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOppTipoAtto->getValidationFailures());
				}
			}


			if (($retval = OppAttoPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collOppAttoHasTeseos !== null) {
					foreach($this->collOppAttoHasTeseos as $referrerFK) {
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


			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppAttoPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getParlamentoId();
				break;
			case 2:
				return $this->getTipoAttoId();
				break;
			case 3:
				return $this->getRamo();
				break;
			case 4:
				return $this->getNumfase();
				break;
			case 5:
				return $this->getLegislatura();
				break;
			case 6:
				return $this->getDataPres();
				break;
			case 7:
				return $this->getDataAgg();
				break;
			case 8:
				return $this->getTitolo();
				break;
			case 9:
				return $this->getIniziativa();
				break;
			case 10:
				return $this->getCompleto();
				break;
			case 11:
				return $this->getDescrizione();
				break;
			case 12:
				return $this->getSeduta();
				break;
			case 13:
				return $this->getIter();
				break;
			case 14:
				return $this->getDataIter();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppAttoPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getParlamentoId(),
			$keys[2] => $this->getTipoAttoId(),
			$keys[3] => $this->getRamo(),
			$keys[4] => $this->getNumfase(),
			$keys[5] => $this->getLegislatura(),
			$keys[6] => $this->getDataPres(),
			$keys[7] => $this->getDataAgg(),
			$keys[8] => $this->getTitolo(),
			$keys[9] => $this->getIniziativa(),
			$keys[10] => $this->getCompleto(),
			$keys[11] => $this->getDescrizione(),
			$keys[12] => $this->getSeduta(),
			$keys[13] => $this->getIter(),
			$keys[14] => $this->getDataIter(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppAttoPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setParlamentoId($value);
				break;
			case 2:
				$this->setTipoAttoId($value);
				break;
			case 3:
				$this->setRamo($value);
				break;
			case 4:
				$this->setNumfase($value);
				break;
			case 5:
				$this->setLegislatura($value);
				break;
			case 6:
				$this->setDataPres($value);
				break;
			case 7:
				$this->setDataAgg($value);
				break;
			case 8:
				$this->setTitolo($value);
				break;
			case 9:
				$this->setIniziativa($value);
				break;
			case 10:
				$this->setCompleto($value);
				break;
			case 11:
				$this->setDescrizione($value);
				break;
			case 12:
				$this->setSeduta($value);
				break;
			case 13:
				$this->setIter($value);
				break;
			case 14:
				$this->setDataIter($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppAttoPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setParlamentoId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setTipoAttoId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setRamo($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setNumfase($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setLegislatura($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setDataPres($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setDataAgg($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setTitolo($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setIniziativa($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setCompleto($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setDescrizione($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setSeduta($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setIter($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setDataIter($arr[$keys[14]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(OppAttoPeer::DATABASE_NAME);

		if ($this->isColumnModified(OppAttoPeer::ID)) $criteria->add(OppAttoPeer::ID, $this->id);
		if ($this->isColumnModified(OppAttoPeer::PARLAMENTO_ID)) $criteria->add(OppAttoPeer::PARLAMENTO_ID, $this->parlamento_id);
		if ($this->isColumnModified(OppAttoPeer::TIPO_ATTO_ID)) $criteria->add(OppAttoPeer::TIPO_ATTO_ID, $this->tipo_atto_id);
		if ($this->isColumnModified(OppAttoPeer::RAMO)) $criteria->add(OppAttoPeer::RAMO, $this->ramo);
		if ($this->isColumnModified(OppAttoPeer::NUMFASE)) $criteria->add(OppAttoPeer::NUMFASE, $this->numfase);
		if ($this->isColumnModified(OppAttoPeer::LEGISLATURA)) $criteria->add(OppAttoPeer::LEGISLATURA, $this->legislatura);
		if ($this->isColumnModified(OppAttoPeer::DATA_PRES)) $criteria->add(OppAttoPeer::DATA_PRES, $this->data_pres);
		if ($this->isColumnModified(OppAttoPeer::DATA_AGG)) $criteria->add(OppAttoPeer::DATA_AGG, $this->data_agg);
		if ($this->isColumnModified(OppAttoPeer::TITOLO)) $criteria->add(OppAttoPeer::TITOLO, $this->titolo);
		if ($this->isColumnModified(OppAttoPeer::INIZIATIVA)) $criteria->add(OppAttoPeer::INIZIATIVA, $this->iniziativa);
		if ($this->isColumnModified(OppAttoPeer::COMPLETO)) $criteria->add(OppAttoPeer::COMPLETO, $this->completo);
		if ($this->isColumnModified(OppAttoPeer::DESCRIZIONE)) $criteria->add(OppAttoPeer::DESCRIZIONE, $this->descrizione);
		if ($this->isColumnModified(OppAttoPeer::SEDUTA)) $criteria->add(OppAttoPeer::SEDUTA, $this->seduta);
		if ($this->isColumnModified(OppAttoPeer::ITER)) $criteria->add(OppAttoPeer::ITER, $this->iter);
		if ($this->isColumnModified(OppAttoPeer::DATA_ITER)) $criteria->add(OppAttoPeer::DATA_ITER, $this->data_iter);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(OppAttoPeer::DATABASE_NAME);

		$criteria->add(OppAttoPeer::ID, $this->id);
		$criteria->add(OppAttoPeer::TIPO_ATTO_ID, $this->tipo_atto_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getId();

		$pks[1] = $this->getTipoAttoId();

		return $pks;
	}

	
	public function setPrimaryKey($keys)
	{

		$this->setId($keys[0]);

		$this->setTipoAttoId($keys[1]);

	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setParlamentoId($this->parlamento_id);

		$copyObj->setRamo($this->ramo);

		$copyObj->setNumfase($this->numfase);

		$copyObj->setLegislatura($this->legislatura);

		$copyObj->setDataPres($this->data_pres);

		$copyObj->setDataAgg($this->data_agg);

		$copyObj->setTitolo($this->titolo);

		$copyObj->setIniziativa($this->iniziativa);

		$copyObj->setCompleto($this->completo);

		$copyObj->setDescrizione($this->descrizione);

		$copyObj->setSeduta($this->seduta);

		$copyObj->setIter($this->iter);

		$copyObj->setDataIter($this->data_iter);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getOppAttoHasTeseos() as $relObj) {
				$copyObj->addOppAttoHasTeseo($relObj->copy($deepCopy));
			}

			foreach($this->getOppCaricaHasAttos() as $relObj) {
				$copyObj->addOppCaricaHasAtto($relObj->copy($deepCopy));
			}

		} 

		$copyObj->setNew(true);

		$copyObj->setId(NULL); 
		$copyObj->setTipoAttoId(NULL); 
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
			self::$peer = new OppAttoPeer();
		}
		return self::$peer;
	}

	
	public function setOppTipoAtto($v)
	{


		if ($v === null) {
			$this->setTipoAttoId(NULL);
		} else {
			$this->setTipoAttoId($v->getId());
		}


		$this->aOppTipoAtto = $v;
	}


	
	public function getOppTipoAtto($con = null)
	{
				include_once 'lib/model/om/BaseOppTipoAttoPeer.php';

		if ($this->aOppTipoAtto === null && ($this->tipo_atto_id !== null)) {

			$this->aOppTipoAtto = OppTipoAttoPeer::retrieveByPK($this->tipo_atto_id, $con);

			
		}
		return $this->aOppTipoAtto;
	}

	
	public function initOppAttoHasTeseos()
	{
		if ($this->collOppAttoHasTeseos === null) {
			$this->collOppAttoHasTeseos = array();
		}
	}

	
	public function getOppAttoHasTeseos($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppAttoHasTeseoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppAttoHasTeseos === null) {
			if ($this->isNew()) {
			   $this->collOppAttoHasTeseos = array();
			} else {

				$criteria->add(OppAttoHasTeseoPeer::ATTO_ID, $this->getId());

				OppAttoHasTeseoPeer::addSelectColumns($criteria);
				$this->collOppAttoHasTeseos = OppAttoHasTeseoPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(OppAttoHasTeseoPeer::ATTO_ID, $this->getId());

				OppAttoHasTeseoPeer::addSelectColumns($criteria);
				if (!isset($this->lastOppAttoHasTeseoCriteria) || !$this->lastOppAttoHasTeseoCriteria->equals($criteria)) {
					$this->collOppAttoHasTeseos = OppAttoHasTeseoPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastOppAttoHasTeseoCriteria = $criteria;
		return $this->collOppAttoHasTeseos;
	}

	
	public function countOppAttoHasTeseos($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseOppAttoHasTeseoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(OppAttoHasTeseoPeer::ATTO_ID, $this->getId());

		return OppAttoHasTeseoPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addOppAttoHasTeseo(OppAttoHasTeseo $l)
	{
		$this->collOppAttoHasTeseos[] = $l;
		$l->setOppAtto($this);
	}


	
	public function getOppAttoHasTeseosJoinOppTeseo($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppAttoHasTeseoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppAttoHasTeseos === null) {
			if ($this->isNew()) {
				$this->collOppAttoHasTeseos = array();
			} else {

				$criteria->add(OppAttoHasTeseoPeer::ATTO_ID, $this->getId());

				$this->collOppAttoHasTeseos = OppAttoHasTeseoPeer::doSelectJoinOppTeseo($criteria, $con);
			}
		} else {
									
			$criteria->add(OppAttoHasTeseoPeer::ATTO_ID, $this->getId());

			if (!isset($this->lastOppAttoHasTeseoCriteria) || !$this->lastOppAttoHasTeseoCriteria->equals($criteria)) {
				$this->collOppAttoHasTeseos = OppAttoHasTeseoPeer::doSelectJoinOppTeseo($criteria, $con);
			}
		}
		$this->lastOppAttoHasTeseoCriteria = $criteria;

		return $this->collOppAttoHasTeseos;
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

				$criteria->add(OppCaricaHasAttoPeer::ATTO_ID, $this->getId());

				OppCaricaHasAttoPeer::addSelectColumns($criteria);
				$this->collOppCaricaHasAttos = OppCaricaHasAttoPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(OppCaricaHasAttoPeer::ATTO_ID, $this->getId());

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

		$criteria->add(OppCaricaHasAttoPeer::ATTO_ID, $this->getId());

		return OppCaricaHasAttoPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addOppCaricaHasAtto(OppCaricaHasAtto $l)
	{
		$this->collOppCaricaHasAttos[] = $l;
		$l->setOppAtto($this);
	}


	
	public function getOppCaricaHasAttosJoinOppCarica($criteria = null, $con = null)
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

				$criteria->add(OppCaricaHasAttoPeer::ATTO_ID, $this->getId());

				$this->collOppCaricaHasAttos = OppCaricaHasAttoPeer::doSelectJoinOppCarica($criteria, $con);
			}
		} else {
									
			$criteria->add(OppCaricaHasAttoPeer::ATTO_ID, $this->getId());

			if (!isset($this->lastOppCaricaHasAttoCriteria) || !$this->lastOppCaricaHasAttoCriteria->equals($criteria)) {
				$this->collOppCaricaHasAttos = OppCaricaHasAttoPeer::doSelectJoinOppCarica($criteria, $con);
			}
		}
		$this->lastOppCaricaHasAttoCriteria = $criteria;

		return $this->collOppCaricaHasAttos;
	}

} 