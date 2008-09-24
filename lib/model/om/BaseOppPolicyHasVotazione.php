<?php


abstract class BaseOppPolicyHasVotazione extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $policy_id;


	
	protected $votazione_id;


	
	protected $voto;


	
	protected $strong;

	
	protected $aOppPolicy;

	
	protected $aOppVotazione;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getPolicyId()
	{

		return $this->policy_id;
	}

	
	public function getVotazioneId()
	{

		return $this->votazione_id;
	}

	
	public function getVoto()
	{

		return $this->voto;
	}

	
	public function getStrong()
	{

		return $this->strong;
	}

	
	public function setPolicyId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->policy_id !== $v) {
			$this->policy_id = $v;
			$this->modifiedColumns[] = OppPolicyHasVotazionePeer::POLICY_ID;
		}

		if ($this->aOppPolicy !== null && $this->aOppPolicy->getId() !== $v) {
			$this->aOppPolicy = null;
		}

	} 
	
	public function setVotazioneId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->votazione_id !== $v) {
			$this->votazione_id = $v;
			$this->modifiedColumns[] = OppPolicyHasVotazionePeer::VOTAZIONE_ID;
		}

		if ($this->aOppVotazione !== null && $this->aOppVotazione->getId() !== $v) {
			$this->aOppVotazione = null;
		}

	} 
	
	public function setVoto($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->voto !== $v) {
			$this->voto = $v;
			$this->modifiedColumns[] = OppPolicyHasVotazionePeer::VOTO;
		}

	} 
	
	public function setStrong($v)
	{

		if ($this->strong !== $v) {
			$this->strong = $v;
			$this->modifiedColumns[] = OppPolicyHasVotazionePeer::STRONG;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->policy_id = $rs->getInt($startcol + 0);

			$this->votazione_id = $rs->getInt($startcol + 1);

			$this->voto = $rs->getString($startcol + 2);

			$this->strong = $rs->getBoolean($startcol + 3);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 4; 
		} catch (Exception $e) {
			throw new PropelException("Error populating OppPolicyHasVotazione object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(OppPolicyHasVotazionePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			OppPolicyHasVotazionePeer::doDelete($this, $con);
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
			$con = Propel::getConnection(OppPolicyHasVotazionePeer::DATABASE_NAME);
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


												
			if ($this->aOppPolicy !== null) {
				if ($this->aOppPolicy->isModified()) {
					$affectedRows += $this->aOppPolicy->save($con);
				}
				$this->setOppPolicy($this->aOppPolicy);
			}

			if ($this->aOppVotazione !== null) {
				if ($this->aOppVotazione->isModified()) {
					$affectedRows += $this->aOppVotazione->save($con);
				}
				$this->setOppVotazione($this->aOppVotazione);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = OppPolicyHasVotazionePeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setNew(false);
				} else {
					$affectedRows += OppPolicyHasVotazionePeer::doUpdate($this, $con);
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


												
			if ($this->aOppPolicy !== null) {
				if (!$this->aOppPolicy->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOppPolicy->getValidationFailures());
				}
			}

			if ($this->aOppVotazione !== null) {
				if (!$this->aOppVotazione->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOppVotazione->getValidationFailures());
				}
			}


			if (($retval = OppPolicyHasVotazionePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppPolicyHasVotazionePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getPolicyId();
				break;
			case 1:
				return $this->getVotazioneId();
				break;
			case 2:
				return $this->getVoto();
				break;
			case 3:
				return $this->getStrong();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppPolicyHasVotazionePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getPolicyId(),
			$keys[1] => $this->getVotazioneId(),
			$keys[2] => $this->getVoto(),
			$keys[3] => $this->getStrong(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppPolicyHasVotazionePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setPolicyId($value);
				break;
			case 1:
				$this->setVotazioneId($value);
				break;
			case 2:
				$this->setVoto($value);
				break;
			case 3:
				$this->setStrong($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppPolicyHasVotazionePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setPolicyId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setVotazioneId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setVoto($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setStrong($arr[$keys[3]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(OppPolicyHasVotazionePeer::DATABASE_NAME);

		if ($this->isColumnModified(OppPolicyHasVotazionePeer::POLICY_ID)) $criteria->add(OppPolicyHasVotazionePeer::POLICY_ID, $this->policy_id);
		if ($this->isColumnModified(OppPolicyHasVotazionePeer::VOTAZIONE_ID)) $criteria->add(OppPolicyHasVotazionePeer::VOTAZIONE_ID, $this->votazione_id);
		if ($this->isColumnModified(OppPolicyHasVotazionePeer::VOTO)) $criteria->add(OppPolicyHasVotazionePeer::VOTO, $this->voto);
		if ($this->isColumnModified(OppPolicyHasVotazionePeer::STRONG)) $criteria->add(OppPolicyHasVotazionePeer::STRONG, $this->strong);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(OppPolicyHasVotazionePeer::DATABASE_NAME);

		$criteria->add(OppPolicyHasVotazionePeer::POLICY_ID, $this->policy_id);
		$criteria->add(OppPolicyHasVotazionePeer::VOTAZIONE_ID, $this->votazione_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getPolicyId();

		$pks[1] = $this->getVotazioneId();

		return $pks;
	}

	
	public function setPrimaryKey($keys)
	{

		$this->setPolicyId($keys[0]);

		$this->setVotazioneId($keys[1]);

	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setVoto($this->voto);

		$copyObj->setStrong($this->strong);


		$copyObj->setNew(true);

		$copyObj->setPolicyId(NULL); 
		$copyObj->setVotazioneId(NULL); 
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
			self::$peer = new OppPolicyHasVotazionePeer();
		}
		return self::$peer;
	}

	
	public function setOppPolicy($v)
	{


		if ($v === null) {
			$this->setPolicyId(NULL);
		} else {
			$this->setPolicyId($v->getId());
		}


		$this->aOppPolicy = $v;
	}


	
	public function getOppPolicy($con = null)
	{
				include_once 'lib/model/om/BaseOppPolicyPeer.php';

		if ($this->aOppPolicy === null && ($this->policy_id !== null)) {

			$this->aOppPolicy = OppPolicyPeer::retrieveByPK($this->policy_id, $con);

			
		}
		return $this->aOppPolicy;
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

} 