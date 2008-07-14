<?php


abstract class BaseOppDdlHasTeseo extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $ddl_id;


	
	protected $teseo_id;

	
	protected $aOppDdl;

	
	protected $aOppTeseo;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getDdlId()
	{

		return $this->ddl_id;
	}

	
	public function getTeseoId()
	{

		return $this->teseo_id;
	}

	
	public function setDdlId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->ddl_id !== $v) {
			$this->ddl_id = $v;
			$this->modifiedColumns[] = OppDdlHasTeseoPeer::DDL_ID;
		}

		if ($this->aOppDdl !== null && $this->aOppDdl->getId() !== $v) {
			$this->aOppDdl = null;
		}

	} 
	
	public function setTeseoId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->teseo_id !== $v) {
			$this->teseo_id = $v;
			$this->modifiedColumns[] = OppDdlHasTeseoPeer::TESEO_ID;
		}

		if ($this->aOppTeseo !== null && $this->aOppTeseo->getId() !== $v) {
			$this->aOppTeseo = null;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->ddl_id = $rs->getInt($startcol + 0);

			$this->teseo_id = $rs->getInt($startcol + 1);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 2; 
		} catch (Exception $e) {
			throw new PropelException("Error populating OppDdlHasTeseo object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(OppDdlHasTeseoPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			OppDdlHasTeseoPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(OppDdlHasTeseoPeer::DATABASE_NAME);
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


												
			if ($this->aOppDdl !== null) {
				if ($this->aOppDdl->isModified()) {
					$affectedRows += $this->aOppDdl->save($con);
				}
				$this->setOppDdl($this->aOppDdl);
			}

			if ($this->aOppTeseo !== null) {
				if ($this->aOppTeseo->isModified()) {
					$affectedRows += $this->aOppTeseo->save($con);
				}
				$this->setOppTeseo($this->aOppTeseo);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = OppDdlHasTeseoPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setNew(false);
				} else {
					$affectedRows += OppDdlHasTeseoPeer::doUpdate($this, $con);
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


												
			if ($this->aOppDdl !== null) {
				if (!$this->aOppDdl->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOppDdl->getValidationFailures());
				}
			}

			if ($this->aOppTeseo !== null) {
				if (!$this->aOppTeseo->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOppTeseo->getValidationFailures());
				}
			}


			if (($retval = OppDdlHasTeseoPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppDdlHasTeseoPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getDdlId();
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
		$keys = OppDdlHasTeseoPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getDdlId(),
			$keys[1] => $this->getTeseoId(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppDdlHasTeseoPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setDdlId($value);
				break;
			case 1:
				$this->setTeseoId($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppDdlHasTeseoPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setDdlId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setTeseoId($arr[$keys[1]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(OppDdlHasTeseoPeer::DATABASE_NAME);

		if ($this->isColumnModified(OppDdlHasTeseoPeer::DDL_ID)) $criteria->add(OppDdlHasTeseoPeer::DDL_ID, $this->ddl_id);
		if ($this->isColumnModified(OppDdlHasTeseoPeer::TESEO_ID)) $criteria->add(OppDdlHasTeseoPeer::TESEO_ID, $this->teseo_id);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(OppDdlHasTeseoPeer::DATABASE_NAME);

		$criteria->add(OppDdlHasTeseoPeer::DDL_ID, $this->ddl_id);
		$criteria->add(OppDdlHasTeseoPeer::TESEO_ID, $this->teseo_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getDdlId();

		$pks[1] = $this->getTeseoId();

		return $pks;
	}

	
	public function setPrimaryKey($keys)
	{

		$this->setDdlId($keys[0]);

		$this->setTeseoId($keys[1]);

	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{


		$copyObj->setNew(true);

		$copyObj->setDdlId(NULL); 
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
			self::$peer = new OppDdlHasTeseoPeer();
		}
		return self::$peer;
	}

	
	public function setOppDdl($v)
	{


		if ($v === null) {
			$this->setDdlId(NULL);
		} else {
			$this->setDdlId($v->getId());
		}


		$this->aOppDdl = $v;
	}


	
	public function getOppDdl($con = null)
	{
				include_once 'lib/model/om/BaseOppDdlPeer.php';

		if ($this->aOppDdl === null && ($this->ddl_id !== null)) {

			$this->aOppDdl = OppDdlPeer::retrieveByPK($this->ddl_id, $con);

			
		}
		return $this->aOppDdl;
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