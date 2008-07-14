<?php


abstract class BaseOppDdl extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $parlamento_id;


	
	protected $tipo;


	
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

	
	protected $collOppCaricaHasDdls;

	
	protected $lastOppCaricaHasDdlCriteria = null;

	
	protected $collOppDdlHasTeseos;

	
	protected $lastOppDdlHasTeseoCriteria = null;

	
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

	
	public function getTipo()
	{

		return $this->tipo;
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
			$this->modifiedColumns[] = OppDdlPeer::ID;
		}

	} 
	
	public function setParlamentoId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->parlamento_id !== $v) {
			$this->parlamento_id = $v;
			$this->modifiedColumns[] = OppDdlPeer::PARLAMENTO_ID;
		}

	} 
	
	public function setTipo($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->tipo !== $v) {
			$this->tipo = $v;
			$this->modifiedColumns[] = OppDdlPeer::TIPO;
		}

	} 
	
	public function setRamo($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->ramo !== $v) {
			$this->ramo = $v;
			$this->modifiedColumns[] = OppDdlPeer::RAMO;
		}

	} 
	
	public function setNumfase($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->numfase !== $v) {
			$this->numfase = $v;
			$this->modifiedColumns[] = OppDdlPeer::NUMFASE;
		}

	} 
	
	public function setLegislatura($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->legislatura !== $v) {
			$this->legislatura = $v;
			$this->modifiedColumns[] = OppDdlPeer::LEGISLATURA;
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
			$this->modifiedColumns[] = OppDdlPeer::DATA_PRES;
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
			$this->modifiedColumns[] = OppDdlPeer::DATA_AGG;
		}

	} 
	
	public function setTitolo($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->titolo !== $v) {
			$this->titolo = $v;
			$this->modifiedColumns[] = OppDdlPeer::TITOLO;
		}

	} 
	
	public function setIniziativa($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->iniziativa !== $v) {
			$this->iniziativa = $v;
			$this->modifiedColumns[] = OppDdlPeer::INIZIATIVA;
		}

	} 
	
	public function setCompleto($v)
	{

		if ($this->completo !== $v) {
			$this->completo = $v;
			$this->modifiedColumns[] = OppDdlPeer::COMPLETO;
		}

	} 
	
	public function setDescrizione($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->descrizione !== $v) {
			$this->descrizione = $v;
			$this->modifiedColumns[] = OppDdlPeer::DESCRIZIONE;
		}

	} 
	
	public function setSeduta($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->seduta !== $v) {
			$this->seduta = $v;
			$this->modifiedColumns[] = OppDdlPeer::SEDUTA;
		}

	} 
	
	public function setIter($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->iter !== $v) {
			$this->iter = $v;
			$this->modifiedColumns[] = OppDdlPeer::ITER;
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
			$this->modifiedColumns[] = OppDdlPeer::DATA_ITER;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->parlamento_id = $rs->getInt($startcol + 1);

			$this->tipo = $rs->getInt($startcol + 2);

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
			throw new PropelException("Error populating OppDdl object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(OppDdlPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			OppDdlPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(OppDdlPeer::DATABASE_NAME);
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


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = OppDdlPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += OppDdlPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collOppCaricaHasDdls !== null) {
				foreach($this->collOppCaricaHasDdls as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collOppDdlHasTeseos !== null) {
				foreach($this->collOppDdlHasTeseos as $referrerFK) {
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


			if (($retval = OppDdlPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collOppCaricaHasDdls !== null) {
					foreach($this->collOppCaricaHasDdls as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collOppDdlHasTeseos !== null) {
					foreach($this->collOppDdlHasTeseos as $referrerFK) {
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
		$pos = OppDdlPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getTipo();
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
		$keys = OppDdlPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getParlamentoId(),
			$keys[2] => $this->getTipo(),
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
		$pos = OppDdlPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setTipo($value);
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
		$keys = OppDdlPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setParlamentoId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setTipo($arr[$keys[2]]);
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
		$criteria = new Criteria(OppDdlPeer::DATABASE_NAME);

		if ($this->isColumnModified(OppDdlPeer::ID)) $criteria->add(OppDdlPeer::ID, $this->id);
		if ($this->isColumnModified(OppDdlPeer::PARLAMENTO_ID)) $criteria->add(OppDdlPeer::PARLAMENTO_ID, $this->parlamento_id);
		if ($this->isColumnModified(OppDdlPeer::TIPO)) $criteria->add(OppDdlPeer::TIPO, $this->tipo);
		if ($this->isColumnModified(OppDdlPeer::RAMO)) $criteria->add(OppDdlPeer::RAMO, $this->ramo);
		if ($this->isColumnModified(OppDdlPeer::NUMFASE)) $criteria->add(OppDdlPeer::NUMFASE, $this->numfase);
		if ($this->isColumnModified(OppDdlPeer::LEGISLATURA)) $criteria->add(OppDdlPeer::LEGISLATURA, $this->legislatura);
		if ($this->isColumnModified(OppDdlPeer::DATA_PRES)) $criteria->add(OppDdlPeer::DATA_PRES, $this->data_pres);
		if ($this->isColumnModified(OppDdlPeer::DATA_AGG)) $criteria->add(OppDdlPeer::DATA_AGG, $this->data_agg);
		if ($this->isColumnModified(OppDdlPeer::TITOLO)) $criteria->add(OppDdlPeer::TITOLO, $this->titolo);
		if ($this->isColumnModified(OppDdlPeer::INIZIATIVA)) $criteria->add(OppDdlPeer::INIZIATIVA, $this->iniziativa);
		if ($this->isColumnModified(OppDdlPeer::COMPLETO)) $criteria->add(OppDdlPeer::COMPLETO, $this->completo);
		if ($this->isColumnModified(OppDdlPeer::DESCRIZIONE)) $criteria->add(OppDdlPeer::DESCRIZIONE, $this->descrizione);
		if ($this->isColumnModified(OppDdlPeer::SEDUTA)) $criteria->add(OppDdlPeer::SEDUTA, $this->seduta);
		if ($this->isColumnModified(OppDdlPeer::ITER)) $criteria->add(OppDdlPeer::ITER, $this->iter);
		if ($this->isColumnModified(OppDdlPeer::DATA_ITER)) $criteria->add(OppDdlPeer::DATA_ITER, $this->data_iter);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(OppDdlPeer::DATABASE_NAME);

		$criteria->add(OppDdlPeer::ID, $this->id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setParlamentoId($this->parlamento_id);

		$copyObj->setTipo($this->tipo);

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

			foreach($this->getOppCaricaHasDdls() as $relObj) {
				$copyObj->addOppCaricaHasDdl($relObj->copy($deepCopy));
			}

			foreach($this->getOppDdlHasTeseos() as $relObj) {
				$copyObj->addOppDdlHasTeseo($relObj->copy($deepCopy));
			}

		} 

		$copyObj->setNew(true);

		$copyObj->setId(NULL); 
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
			self::$peer = new OppDdlPeer();
		}
		return self::$peer;
	}

	
	public function initOppCaricaHasDdls()
	{
		if ($this->collOppCaricaHasDdls === null) {
			$this->collOppCaricaHasDdls = array();
		}
	}

	
	public function getOppCaricaHasDdls($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppCaricaHasDdlPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppCaricaHasDdls === null) {
			if ($this->isNew()) {
			   $this->collOppCaricaHasDdls = array();
			} else {

				$criteria->add(OppCaricaHasDdlPeer::DDL_ID, $this->getId());

				OppCaricaHasDdlPeer::addSelectColumns($criteria);
				$this->collOppCaricaHasDdls = OppCaricaHasDdlPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(OppCaricaHasDdlPeer::DDL_ID, $this->getId());

				OppCaricaHasDdlPeer::addSelectColumns($criteria);
				if (!isset($this->lastOppCaricaHasDdlCriteria) || !$this->lastOppCaricaHasDdlCriteria->equals($criteria)) {
					$this->collOppCaricaHasDdls = OppCaricaHasDdlPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastOppCaricaHasDdlCriteria = $criteria;
		return $this->collOppCaricaHasDdls;
	}

	
	public function countOppCaricaHasDdls($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseOppCaricaHasDdlPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(OppCaricaHasDdlPeer::DDL_ID, $this->getId());

		return OppCaricaHasDdlPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addOppCaricaHasDdl(OppCaricaHasDdl $l)
	{
		$this->collOppCaricaHasDdls[] = $l;
		$l->setOppDdl($this);
	}


	
	public function getOppCaricaHasDdlsJoinOppCarica($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppCaricaHasDdlPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppCaricaHasDdls === null) {
			if ($this->isNew()) {
				$this->collOppCaricaHasDdls = array();
			} else {

				$criteria->add(OppCaricaHasDdlPeer::DDL_ID, $this->getId());

				$this->collOppCaricaHasDdls = OppCaricaHasDdlPeer::doSelectJoinOppCarica($criteria, $con);
			}
		} else {
									
			$criteria->add(OppCaricaHasDdlPeer::DDL_ID, $this->getId());

			if (!isset($this->lastOppCaricaHasDdlCriteria) || !$this->lastOppCaricaHasDdlCriteria->equals($criteria)) {
				$this->collOppCaricaHasDdls = OppCaricaHasDdlPeer::doSelectJoinOppCarica($criteria, $con);
			}
		}
		$this->lastOppCaricaHasDdlCriteria = $criteria;

		return $this->collOppCaricaHasDdls;
	}

	
	public function initOppDdlHasTeseos()
	{
		if ($this->collOppDdlHasTeseos === null) {
			$this->collOppDdlHasTeseos = array();
		}
	}

	
	public function getOppDdlHasTeseos($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppDdlHasTeseoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppDdlHasTeseos === null) {
			if ($this->isNew()) {
			   $this->collOppDdlHasTeseos = array();
			} else {

				$criteria->add(OppDdlHasTeseoPeer::DDL_ID, $this->getId());

				OppDdlHasTeseoPeer::addSelectColumns($criteria);
				$this->collOppDdlHasTeseos = OppDdlHasTeseoPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(OppDdlHasTeseoPeer::DDL_ID, $this->getId());

				OppDdlHasTeseoPeer::addSelectColumns($criteria);
				if (!isset($this->lastOppDdlHasTeseoCriteria) || !$this->lastOppDdlHasTeseoCriteria->equals($criteria)) {
					$this->collOppDdlHasTeseos = OppDdlHasTeseoPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastOppDdlHasTeseoCriteria = $criteria;
		return $this->collOppDdlHasTeseos;
	}

	
	public function countOppDdlHasTeseos($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseOppDdlHasTeseoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(OppDdlHasTeseoPeer::DDL_ID, $this->getId());

		return OppDdlHasTeseoPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addOppDdlHasTeseo(OppDdlHasTeseo $l)
	{
		$this->collOppDdlHasTeseos[] = $l;
		$l->setOppDdl($this);
	}


	
	public function getOppDdlHasTeseosJoinOppTeseo($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppDdlHasTeseoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppDdlHasTeseos === null) {
			if ($this->isNew()) {
				$this->collOppDdlHasTeseos = array();
			} else {

				$criteria->add(OppDdlHasTeseoPeer::DDL_ID, $this->getId());

				$this->collOppDdlHasTeseos = OppDdlHasTeseoPeer::doSelectJoinOppTeseo($criteria, $con);
			}
		} else {
									
			$criteria->add(OppDdlHasTeseoPeer::DDL_ID, $this->getId());

			if (!isset($this->lastOppDdlHasTeseoCriteria) || !$this->lastOppDdlHasTeseoCriteria->equals($criteria)) {
				$this->collOppDdlHasTeseos = OppDdlHasTeseoPeer::doSelectJoinOppTeseo($criteria, $con);
			}
		}
		$this->lastOppDdlHasTeseoCriteria = $criteria;

		return $this->collOppDdlHasTeseos;
	}

} 