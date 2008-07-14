<?php


abstract class BaseOppLegislaturaHasGruppo extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $legislatura;


	
	protected $ramo;


	
	protected $gruppo_id;

	
	protected $aOppGruppo;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getLegislatura()
	{

		return $this->legislatura;
	}

	
	public function getRamo()
	{

		return $this->ramo;
	}

	
	public function getGruppoId()
	{

		return $this->gruppo_id;
	}

	
	public function setLegislatura($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->legislatura !== $v) {
			$this->legislatura = $v;
			$this->modifiedColumns[] = OppLegislaturaHasGruppoPeer::LEGISLATURA;
		}

	} 
	
	public function setRamo($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->ramo !== $v) {
			$this->ramo = $v;
			$this->modifiedColumns[] = OppLegislaturaHasGruppoPeer::RAMO;
		}

	} 
	
	public function setGruppoId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->gruppo_id !== $v) {
			$this->gruppo_id = $v;
			$this->modifiedColumns[] = OppLegislaturaHasGruppoPeer::GRUPPO_ID;
		}

		if ($this->aOppGruppo !== null && $this->aOppGruppo->getId() !== $v) {
			$this->aOppGruppo = null;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->legislatura = $rs->getInt($startcol + 0);

			$this->ramo = $rs->getString($startcol + 1);

			$this->gruppo_id = $rs->getInt($startcol + 2);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 3; 
		} catch (Exception $e) {
			throw new PropelException("Error populating OppLegislaturaHasGruppo object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(OppLegislaturaHasGruppoPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			OppLegislaturaHasGruppoPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(OppLegislaturaHasGruppoPeer::DATABASE_NAME);
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


												
			if ($this->aOppGruppo !== null) {
				if ($this->aOppGruppo->isModified()) {
					$affectedRows += $this->aOppGruppo->save($con);
				}
				$this->setOppGruppo($this->aOppGruppo);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = OppLegislaturaHasGruppoPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setNew(false);
				} else {
					$affectedRows += OppLegislaturaHasGruppoPeer::doUpdate($this, $con);
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


												
			if ($this->aOppGruppo !== null) {
				if (!$this->aOppGruppo->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOppGruppo->getValidationFailures());
				}
			}


			if (($retval = OppLegislaturaHasGruppoPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppLegislaturaHasGruppoPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getLegislatura();
				break;
			case 1:
				return $this->getRamo();
				break;
			case 2:
				return $this->getGruppoId();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppLegislaturaHasGruppoPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getLegislatura(),
			$keys[1] => $this->getRamo(),
			$keys[2] => $this->getGruppoId(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppLegislaturaHasGruppoPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setLegislatura($value);
				break;
			case 1:
				$this->setRamo($value);
				break;
			case 2:
				$this->setGruppoId($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppLegislaturaHasGruppoPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setLegislatura($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setRamo($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setGruppoId($arr[$keys[2]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(OppLegislaturaHasGruppoPeer::DATABASE_NAME);

		if ($this->isColumnModified(OppLegislaturaHasGruppoPeer::LEGISLATURA)) $criteria->add(OppLegislaturaHasGruppoPeer::LEGISLATURA, $this->legislatura);
		if ($this->isColumnModified(OppLegislaturaHasGruppoPeer::RAMO)) $criteria->add(OppLegislaturaHasGruppoPeer::RAMO, $this->ramo);
		if ($this->isColumnModified(OppLegislaturaHasGruppoPeer::GRUPPO_ID)) $criteria->add(OppLegislaturaHasGruppoPeer::GRUPPO_ID, $this->gruppo_id);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(OppLegislaturaHasGruppoPeer::DATABASE_NAME);

		$criteria->add(OppLegislaturaHasGruppoPeer::LEGISLATURA, $this->legislatura);
		$criteria->add(OppLegislaturaHasGruppoPeer::RAMO, $this->ramo);
		$criteria->add(OppLegislaturaHasGruppoPeer::GRUPPO_ID, $this->gruppo_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getLegislatura();

		$pks[1] = $this->getRamo();

		$pks[2] = $this->getGruppoId();

		return $pks;
	}

	
	public function setPrimaryKey($keys)
	{

		$this->setLegislatura($keys[0]);

		$this->setRamo($keys[1]);

		$this->setGruppoId($keys[2]);

	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{


		$copyObj->setNew(true);

		$copyObj->setLegislatura(NULL); 
		$copyObj->setRamo(NULL); 
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
			self::$peer = new OppLegislaturaHasGruppoPeer();
		}
		return self::$peer;
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