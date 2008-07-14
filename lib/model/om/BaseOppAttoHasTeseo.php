<?php


abstract class BaseOppAttoHasTeseo extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $atto_id;


	
	protected $teseo_id;

	
	protected $aOppAtto;

	
	protected $aOppTeseo;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getAttoId()
	{

		return $this->atto_id;
	}

	
	public function getTeseoId()
	{

		return $this->teseo_id;
	}

	
	public function setAttoId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->atto_id !== $v) {
			$this->atto_id = $v;
			$this->modifiedColumns[] = OppAttoHasTeseoPeer::ATTO_ID;
		}

		if ($this->aOppAtto !== null && $this->aOppAtto->getId() !== $v) {
			$this->aOppAtto = null;
		}

	} 
	
	public function setTeseoId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->teseo_id !== $v) {
			$this->teseo_id = $v;
			$this->modifiedColumns[] = OppAttoHasTeseoPeer::TESEO_ID;
		}

		if ($this->aOppTeseo !== null && $this->aOppTeseo->getId() !== $v) {
			$this->aOppTeseo = null;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->atto_id = $rs->getInt($startcol + 0);

			$this->teseo_id = $rs->getInt($startcol + 1);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 2; 
		} catch (Exception $e) {
			throw new PropelException("Error populating OppAttoHasTeseo object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(OppAttoHasTeseoPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			OppAttoHasTeseoPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(OppAttoHasTeseoPeer::DATABASE_NAME);
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


												
			if ($this->aOppAtto !== null) {
				if ($this->aOppAtto->isModified()) {
					$affectedRows += $this->aOppAtto->save($con);
				}
				$this->setOppAtto($this->aOppAtto);
			}

			if ($this->aOppTeseo !== null) {
				if ($this->aOppTeseo->isModified()) {
					$affectedRows += $this->aOppTeseo->save($con);
				}
				$this->setOppTeseo($this->aOppTeseo);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = OppAttoHasTeseoPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setNew(false);
				} else {
					$affectedRows += OppAttoHasTeseoPeer::doUpdate($this, $con);
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


												
			if ($this->aOppAtto !== null) {
				if (!$this->aOppAtto->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOppAtto->getValidationFailures());
				}
			}

			if ($this->aOppTeseo !== null) {
				if (!$this->aOppTeseo->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOppTeseo->getValidationFailures());
				}
			}


			if (($retval = OppAttoHasTeseoPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppAttoHasTeseoPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getAttoId();
				break;
			case 1:
				return $this->getTeseoId();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppAttoHasTeseoPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getAttoId(),
			$keys[1] => $this->getTeseoId(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppAttoHasTeseoPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setAttoId($value);
				break;
			case 1:
				$this->setTeseoId($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppAttoHasTeseoPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setAttoId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setTeseoId($arr[$keys[1]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(OppAttoHasTeseoPeer::DATABASE_NAME);

		if ($this->isColumnModified(OppAttoHasTeseoPeer::ATTO_ID)) $criteria->add(OppAttoHasTeseoPeer::ATTO_ID, $this->atto_id);
		if ($this->isColumnModified(OppAttoHasTeseoPeer::TESEO_ID)) $criteria->add(OppAttoHasTeseoPeer::TESEO_ID, $this->teseo_id);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(OppAttoHasTeseoPeer::DATABASE_NAME);

		$criteria->add(OppAttoHasTeseoPeer::ATTO_ID, $this->atto_id);
		$criteria->add(OppAttoHasTeseoPeer::TESEO_ID, $this->teseo_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getAttoId();

		$pks[1] = $this->getTeseoId();

		return $pks;
	}

	
	public function setPrimaryKey($keys)
	{

		$this->setAttoId($keys[0]);

		$this->setTeseoId($keys[1]);

	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{


		$copyObj->setNew(true);

		$copyObj->setAttoId(NULL); 
		$copyObj->setTeseoId(NULL); 
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
			self::$peer = new OppAttoHasTeseoPeer();
		}
		return self::$peer;
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

	
	public function setOppTeseo($v)
	{


		if ($v === null) {
			$this->setTeseoId(NULL);
		} else {
			$this->setTeseoId($v->getId());
		}


		$this->aOppTeseo = $v;
	}


	
	public function getOppTeseo($con = null)
	{
				include_once 'lib/model/om/BaseOppTeseoPeer.php';

		if ($this->aOppTeseo === null && ($this->teseo_id !== null)) {

			$this->aOppTeseo = OppTeseoPeer::retrieveByPK($this->teseo_id, $con);

			
		}
		return $this->aOppTeseo;
	}

} 