<?php


abstract class BaseOppCaricaHasGruppo extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $carica_id;


	
	protected $gruppo_id;


	
	protected $data_inizio;


	
	protected $data_fine;


	
	protected $ribelle;

	
	protected $aOppCarica;

	
	protected $aOppGruppo;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getCaricaId()
	{

		return $this->carica_id;
	}

	
	public function getGruppoId()
	{

		return $this->gruppo_id;
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

	
	public function getRibelle()
	{

		return $this->ribelle;
	}

	
	public function setCaricaId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->carica_id !== $v) {
			$this->carica_id = $v;
			$this->modifiedColumns[] = OppCaricaHasGruppoPeer::CARICA_ID;
		}

		if ($this->aOppCarica !== null && $this->aOppCarica->getId() !== $v) {
			$this->aOppCarica = null;
		}

	} 
	
	public function setGruppoId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->gruppo_id !== $v) {
			$this->gruppo_id = $v;
			$this->modifiedColumns[] = OppCaricaHasGruppoPeer::GRUPPO_ID;
		}

		if ($this->aOppGruppo !== null && $this->aOppGruppo->getId() !== $v) {
			$this->aOppGruppo = null;
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
			$this->modifiedColumns[] = OppCaricaHasGruppoPeer::DATA_INIZIO;
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
			$this->modifiedColumns[] = OppCaricaHasGruppoPeer::DATA_FINE;
		}

	} 
	
	public function setRibelle($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->ribelle !== $v) {
			$this->ribelle = $v;
			$this->modifiedColumns[] = OppCaricaHasGruppoPeer::RIBELLE;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->carica_id = $rs->getInt($startcol + 0);

			$this->gruppo_id = $rs->getInt($startcol + 1);

			$this->data_inizio = $rs->getDate($startcol + 2, null);

			$this->data_fine = $rs->getDate($startcol + 3, null);

			$this->ribelle = $rs->getInt($startcol + 4);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 5; 
		} catch (Exception $e) {
			throw new PropelException("Error populating OppCaricaHasGruppo object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(OppCaricaHasGruppoPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			OppCaricaHasGruppoPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(OppCaricaHasGruppoPeer::DATABASE_NAME);
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


												
			if ($this->aOppCarica !== null) {
				if ($this->aOppCarica->isModified()) {
					$affectedRows += $this->aOppCarica->save($con);
				}
				$this->setOppCarica($this->aOppCarica);
			}

			if ($this->aOppGruppo !== null) {
				if ($this->aOppGruppo->isModified()) {
					$affectedRows += $this->aOppGruppo->save($con);
				}
				$this->setOppGruppo($this->aOppGruppo);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = OppCaricaHasGruppoPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setNew(false);
				} else {
					$affectedRows += OppCaricaHasGruppoPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

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


												
			if ($this->aOppCarica !== null) {
				if (!$this->aOppCarica->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOppCarica->getValidationFailures());
				}
			}

			if ($this->aOppGruppo !== null) {
				if (!$this->aOppGruppo->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOppGruppo->getValidationFailures());
				}
			}


			if (($retval = OppCaricaHasGruppoPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppCaricaHasGruppoPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getCaricaId();
				break;
			case 1:
				return $this->getGruppoId();
				break;
			case 2:
				return $this->getDataInizio();
				break;
			case 3:
				return $this->getDataFine();
				break;
			case 4:
				return $this->getRibelle();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppCaricaHasGruppoPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCaricaId(),
			$keys[1] => $this->getGruppoId(),
			$keys[2] => $this->getDataInizio(),
			$keys[3] => $this->getDataFine(),
			$keys[4] => $this->getRibelle(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppCaricaHasGruppoPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setCaricaId($value);
				break;
			case 1:
				$this->setGruppoId($value);
				break;
			case 2:
				$this->setDataInizio($value);
				break;
			case 3:
				$this->setDataFine($value);
				break;
			case 4:
				$this->setRibelle($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppCaricaHasGruppoPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCaricaId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setGruppoId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setDataInizio($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setDataFine($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setRibelle($arr[$keys[4]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(OppCaricaHasGruppoPeer::DATABASE_NAME);

		if ($this->isColumnModified(OppCaricaHasGruppoPeer::CARICA_ID)) $criteria->add(OppCaricaHasGruppoPeer::CARICA_ID, $this->carica_id);
		if ($this->isColumnModified(OppCaricaHasGruppoPeer::GRUPPO_ID)) $criteria->add(OppCaricaHasGruppoPeer::GRUPPO_ID, $this->gruppo_id);
		if ($this->isColumnModified(OppCaricaHasGruppoPeer::DATA_INIZIO)) $criteria->add(OppCaricaHasGruppoPeer::DATA_INIZIO, $this->data_inizio);
		if ($this->isColumnModified(OppCaricaHasGruppoPeer::DATA_FINE)) $criteria->add(OppCaricaHasGruppoPeer::DATA_FINE, $this->data_fine);
		if ($this->isColumnModified(OppCaricaHasGruppoPeer::RIBELLE)) $criteria->add(OppCaricaHasGruppoPeer::RIBELLE, $this->ribelle);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(OppCaricaHasGruppoPeer::DATABASE_NAME);

		$criteria->add(OppCaricaHasGruppoPeer::CARICA_ID, $this->carica_id);
		$criteria->add(OppCaricaHasGruppoPeer::GRUPPO_ID, $this->gruppo_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getCaricaId();

		$pks[1] = $this->getGruppoId();

		return $pks;
	}

	
	public function setPrimaryKey($keys)
	{

		$this->setCaricaId($keys[0]);

		$this->setGruppoId($keys[1]);

	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setDataInizio($this->data_inizio);

		$copyObj->setDataFine($this->data_fine);

		$copyObj->setRibelle($this->ribelle);


		$copyObj->setNew(true);

		$copyObj->setCaricaId(NULL); 
		$copyObj->setGruppoId(NULL); 
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
			self::$peer = new OppCaricaHasGruppoPeer();
		}
		return self::$peer;
	}

	
	public function setOppCarica($v)
	{


		if ($v === null) {
			$this->setCaricaId(NULL);
		} else {
			$this->setCaricaId($v->getId());
		}


		$this->aOppCarica = $v;
	}


	
	public function getOppCarica($con = null)
	{
				include_once 'lib/model/om/BaseOppCaricaPeer.php';

		if ($this->aOppCarica === null && ($this->carica_id !== null)) {

			$this->aOppCarica = OppCaricaPeer::retrieveByPK($this->carica_id, $con);

			
		}
		return $this->aOppCarica;
	}

	
	public function setOppGruppo($v)
	{


		if ($v === null) {
			$this->setGruppoId(NULL);
		} else {
			$this->setGruppoId($v->getId());
		}


		$this->aOppGruppo = $v;
	}


	
	public function getOppGruppo($con = null)
	{
				include_once 'lib/model/om/BaseOppGruppoPeer.php';

		if ($this->aOppGruppo === null && ($this->gruppo_id !== null)) {

			$this->aOppGruppo = OppGruppoPeer::retrieveByPK($this->gruppo_id, $con);

			
		}
		return $this->aOppGruppo;
	}

} 