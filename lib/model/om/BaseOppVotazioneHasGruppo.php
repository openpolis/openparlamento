<?php


abstract class BaseOppVotazioneHasGruppo extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $votazione_id;


	
	protected $gruppo_id;


	
	protected $voto;

	
	protected $aOppVotazione;

	
	protected $aOppGruppo;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getVotazioneId()
	{

		return $this->votazione_id;
	}

	
	public function getGruppoId()
	{

		return $this->gruppo_id;
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
			$this->modifiedColumns[] = OppVotazioneHasGruppoPeer::VOTAZIONE_ID;
		}

		if ($this->aOppVotazione !== null && $this->aOppVotazione->getId() !== $v) {
			$this->aOppVotazione = null;
		}

	} 
	
	public function setGruppoId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->gruppo_id !== $v) {
			$this->gruppo_id = $v;
			$this->modifiedColumns[] = OppVotazioneHasGruppoPeer::GRUPPO_ID;
		}

		if ($this->aOppGruppo !== null && $this->aOppGruppo->getId() !== $v) {
			$this->aOppGruppo = null;
		}

	} 
	
	public function setVoto($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->voto !== $v) {
			$this->voto = $v;
			$this->modifiedColumns[] = OppVotazioneHasGruppoPeer::VOTO;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->votazione_id = $rs->getInt($startcol + 0);

			$this->gruppo_id = $rs->getInt($startcol + 1);

			$this->voto = $rs->getString($startcol + 2);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 3; 
		} catch (Exception $e) {
			throw new PropelException("Error populating OppVotazioneHasGruppo object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(OppVotazioneHasGruppoPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			OppVotazioneHasGruppoPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(OppVotazioneHasGruppoPeer::DATABASE_NAME);
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

			if ($this->aOppGruppo !== null) {
				if ($this->aOppGruppo->isModified()) {
					$affectedRows += $this->aOppGruppo->save($con);
				}
				$this->setOppGruppo($this->aOppGruppo);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = OppVotazioneHasGruppoPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setNew(false);
				} else {
					$affectedRows += OppVotazioneHasGruppoPeer::doUpdate($this, $con);
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

			if ($this->aOppGruppo !== null) {
				if (!$this->aOppGruppo->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOppGruppo->getValidationFailures());
				}
			}


			if (($retval = OppVotazioneHasGruppoPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppVotazioneHasGruppoPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getVotazioneId();
				break;
			case 1:
				return $this->getGruppoId();
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
		$keys = OppVotazioneHasGruppoPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getVotazioneId(),
			$keys[1] => $this->getGruppoId(),
			$keys[2] => $this->getVoto(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppVotazioneHasGruppoPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setVotazioneId($value);
				break;
			case 1:
				$this->setGruppoId($value);
				break;
			case 2:
				$this->setVoto($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppVotazioneHasGruppoPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setVotazioneId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setGruppoId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setVoto($arr[$keys[2]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(OppVotazioneHasGruppoPeer::DATABASE_NAME);

		if ($this->isColumnModified(OppVotazioneHasGruppoPeer::VOTAZIONE_ID)) $criteria->add(OppVotazioneHasGruppoPeer::VOTAZIONE_ID, $this->votazione_id);
		if ($this->isColumnModified(OppVotazioneHasGruppoPeer::GRUPPO_ID)) $criteria->add(OppVotazioneHasGruppoPeer::GRUPPO_ID, $this->gruppo_id);
		if ($this->isColumnModified(OppVotazioneHasGruppoPeer::VOTO)) $criteria->add(OppVotazioneHasGruppoPeer::VOTO, $this->voto);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(OppVotazioneHasGruppoPeer::DATABASE_NAME);

		$criteria->add(OppVotazioneHasGruppoPeer::VOTAZIONE_ID, $this->votazione_id);
		$criteria->add(OppVotazioneHasGruppoPeer::GRUPPO_ID, $this->gruppo_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getVotazioneId();

		$pks[1] = $this->getGruppoId();

		return $pks;
	}

	
	public function setPrimaryKey($keys)
	{

		$this->setVotazioneId($keys[0]);

		$this->setGruppoId($keys[1]);

	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setVoto($this->voto);


		$copyObj->setNew(true);

		$copyObj->setVotazioneId(NULL); 
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
			self::$peer = new OppVotazioneHasGruppoPeer();
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