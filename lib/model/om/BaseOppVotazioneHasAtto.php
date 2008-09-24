<?php


abstract class BaseOppVotazioneHasAtto extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $votazione_id;


	
	protected $atto_id;

	
	protected $aOppVotazione;

	
	protected $aOppAtto;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getVotazioneId()
	{

		return $this->votazione_id;
	}

	
	public function getAttoId()
	{

		return $this->atto_id;
	}

	
	public function setVotazioneId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->votazione_id !== $v) {
			$this->votazione_id = $v;
			$this->modifiedColumns[] = OppVotazioneHasAttoPeer::VOTAZIONE_ID;
		}

		if ($this->aOppVotazione !== null && $this->aOppVotazione->getId() !== $v) {
			$this->aOppVotazione = null;
		}

	} 
	
	public function setAttoId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->atto_id !== $v) {
			$this->atto_id = $v;
			$this->modifiedColumns[] = OppVotazioneHasAttoPeer::ATTO_ID;
		}

		if ($this->aOppAtto !== null && $this->aOppAtto->getId() !== $v) {
			$this->aOppAtto = null;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->votazione_id = $rs->getInt($startcol + 0);

			$this->atto_id = $rs->getInt($startcol + 1);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 2; 
		} catch (Exception $e) {
			throw new PropelException("Error populating OppVotazioneHasAtto object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(OppVotazioneHasAttoPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			OppVotazioneHasAttoPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(OppVotazioneHasAttoPeer::DATABASE_NAME);
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


												
			if ($this->aOppVotazione !== null) {
				if ($this->aOppVotazione->isModified()) {
					$affectedRows += $this->aOppVotazione->save($con);
				}
				$this->setOppVotazione($this->aOppVotazione);
			}

			if ($this->aOppAtto !== null) {
				if ($this->aOppAtto->isModified()) {
					$affectedRows += $this->aOppAtto->save($con);
				}
				$this->setOppAtto($this->aOppAtto);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = OppVotazioneHasAttoPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setNew(false);
				} else {
					$affectedRows += OppVotazioneHasAttoPeer::doUpdate($this, $con);
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


												
			if ($this->aOppVotazione !== null) {
				if (!$this->aOppVotazione->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOppVotazione->getValidationFailures());
				}
			}

			if ($this->aOppAtto !== null) {
				if (!$this->aOppAtto->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOppAtto->getValidationFailures());
				}
			}


			if (($retval = OppVotazioneHasAttoPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppVotazioneHasAttoPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getVotazioneId();
				break;
			case 1:
				return $this->getAttoId();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppVotazioneHasAttoPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getVotazioneId(),
			$keys[1] => $this->getAttoId(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppVotazioneHasAttoPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setVotazioneId($value);
				break;
			case 1:
				$this->setAttoId($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppVotazioneHasAttoPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setVotazioneId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setAttoId($arr[$keys[1]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(OppVotazioneHasAttoPeer::DATABASE_NAME);

		if ($this->isColumnModified(OppVotazioneHasAttoPeer::VOTAZIONE_ID)) $criteria->add(OppVotazioneHasAttoPeer::VOTAZIONE_ID, $this->votazione_id);
		if ($this->isColumnModified(OppVotazioneHasAttoPeer::ATTO_ID)) $criteria->add(OppVotazioneHasAttoPeer::ATTO_ID, $this->atto_id);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(OppVotazioneHasAttoPeer::DATABASE_NAME);

		$criteria->add(OppVotazioneHasAttoPeer::VOTAZIONE_ID, $this->votazione_id);
		$criteria->add(OppVotazioneHasAttoPeer::ATTO_ID, $this->atto_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getVotazioneId();

		$pks[1] = $this->getAttoId();

		return $pks;
	}

	
	public function setPrimaryKey($keys)
	{

		$this->setVotazioneId($keys[0]);

		$this->setAttoId($keys[1]);

	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{


		$copyObj->setNew(true);

		$copyObj->setVotazioneId(NULL); 
		$copyObj->setAttoId(NULL); 
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
			self::$peer = new OppVotazioneHasAttoPeer();
		}
		return self::$peer;
	}

	
	public function setOppVotazione($v)
	{


		if ($v === null) {
			$this->setVotazioneId(NULL);
		} else {
			$this->setVotazioneId($v->getId());
		}


		$this->aOppVotazione = $v;
	}


	
	public function getOppVotazione($con = null)
	{
				include_once 'lib/model/om/BaseOppVotazionePeer.php';

		if ($this->aOppVotazione === null && ($this->votazione_id !== null)) {

			$this->aOppVotazione = OppVotazionePeer::retrieveByPK($this->votazione_id, $con);

			
		}
		return $this->aOppVotazione;
	}

	
	public function setOppAtto($v)
	{


		if ($v === null) {
			$this->setAttoId(NULL);
		} else {
			$this->setAttoId($v->getId());
		}


		$this->aOppAtto = $v;
	}


	
	public function getOppAtto($con = null)
	{
				include_once 'lib/model/om/BaseOppAttoPeer.php';

		if ($this->aOppAtto === null && ($this->atto_id !== null)) {

			$this->aOppAtto = OppAttoPeer::retrieveByPK($this->atto_id, $con);

			
		}
		return $this->aOppAtto;
	}

} 