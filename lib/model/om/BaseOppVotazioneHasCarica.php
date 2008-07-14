<?php


abstract class BaseOppVotazioneHasCarica extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $votazione_id;


	
	protected $carica_id;


	
	protected $voto;

	
	protected $aOppVotazione;

	
	protected $aOppCarica;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getVotazioneId()
	{

		return $this->votazione_id;
	}

	
	public function getCaricaId()
	{

		return $this->carica_id;
	}

	
	public function getVoto()
	{

		return $this->voto;
	}

	
	public function setVotazioneId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->votazione_id !== $v) {
			$this->votazione_id = $v;
			$this->modifiedColumns[] = OppVotazioneHasCaricaPeer::VOTAZIONE_ID;
		}

		if ($this->aOppVotazione !== null && $this->aOppVotazione->getId() !== $v) {
			$this->aOppVotazione = null;
		}

	} 
	
	public function setCaricaId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->carica_id !== $v) {
			$this->carica_id = $v;
			$this->modifiedColumns[] = OppVotazioneHasCaricaPeer::CARICA_ID;
		}

		if ($this->aOppCarica !== null && $this->aOppCarica->getId() !== $v) {
			$this->aOppCarica = null;
		}

	} 
	
	public function setVoto($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->voto !== $v) {
			$this->voto = $v;
			$this->modifiedColumns[] = OppVotazioneHasCaricaPeer::VOTO;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->votazione_id = $rs->getInt($startcol + 0);

			$this->carica_id = $rs->getInt($startcol + 1);

			$this->voto = $rs->getString($startcol + 2);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 3; 
		} catch (Exception $e) {
			throw new PropelException("Error populating OppVotazioneHasCarica object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(OppVotazioneHasCaricaPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			OppVotazioneHasCaricaPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(OppVotazioneHasCaricaPeer::DATABASE_NAME);
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

			if ($this->aOppCarica !== null) {
				if ($this->aOppCarica->isModified()) {
					$affectedRows += $this->aOppCarica->save($con);
				}
				$this->setOppCarica($this->aOppCarica);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = OppVotazioneHasCaricaPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setNew(false);
				} else {
					$affectedRows += OppVotazioneHasCaricaPeer::doUpdate($this, $con);
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

			if ($this->aOppCarica !== null) {
				if (!$this->aOppCarica->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOppCarica->getValidationFailures());
				}
			}


			if (($retval = OppVotazioneHasCaricaPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppVotazioneHasCaricaPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getVotazioneId();
				break;
			case 1:
				return $this->getCaricaId();
				break;
			case 2:
				return $this->getVoto();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppVotazioneHasCaricaPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getVotazioneId(),
			$keys[1] => $this->getCaricaId(),
			$keys[2] => $this->getVoto(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppVotazioneHasCaricaPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setVotazioneId($value);
				break;
			case 1:
				$this->setCaricaId($value);
				break;
			case 2:
				$this->setVoto($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppVotazioneHasCaricaPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setVotazioneId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setCaricaId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setVoto($arr[$keys[2]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(OppVotazioneHasCaricaPeer::DATABASE_NAME);

		if ($this->isColumnModified(OppVotazioneHasCaricaPeer::VOTAZIONE_ID)) $criteria->add(OppVotazioneHasCaricaPeer::VOTAZIONE_ID, $this->votazione_id);
		if ($this->isColumnModified(OppVotazioneHasCaricaPeer::CARICA_ID)) $criteria->add(OppVotazioneHasCaricaPeer::CARICA_ID, $this->carica_id);
		if ($this->isColumnModified(OppVotazioneHasCaricaPeer::VOTO)) $criteria->add(OppVotazioneHasCaricaPeer::VOTO, $this->voto);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(OppVotazioneHasCaricaPeer::DATABASE_NAME);

		$criteria->add(OppVotazioneHasCaricaPeer::VOTAZIONE_ID, $this->votazione_id);
		$criteria->add(OppVotazioneHasCaricaPeer::CARICA_ID, $this->carica_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getVotazioneId();

		$pks[1] = $this->getCaricaId();

		return $pks;
	}

	
	public function setPrimaryKey($keys)
	{

		$this->setVotazioneId($keys[0]);

		$this->setCaricaId($keys[1]);

	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setVoto($this->voto);


		$copyObj->setNew(true);

		$copyObj->setVotazioneId(NULL); 
		$copyObj->setCaricaId(NULL); 
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
			self::$peer = new OppVotazioneHasCaricaPeer();
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

} 