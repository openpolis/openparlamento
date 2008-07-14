<?php


abstract class BaseOppTeseoHasTeseott extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $opp_teseo_id;


	
	protected $opp_teseott_id;

	
	protected $aOppTeseo;

	
	protected $aOppTeseott;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getOppTeseoId()
	{

		return $this->opp_teseo_id;
	}

	
	public function getOppTeseottId()
	{

		return $this->opp_teseott_id;
	}

	
	public function setOppTeseoId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->opp_teseo_id !== $v) {
			$this->opp_teseo_id = $v;
			$this->modifiedColumns[] = OppTeseoHasTeseottPeer::OPP_TESEO_ID;
		}

		if ($this->aOppTeseo !== null && $this->aOppTeseo->getId() !== $v) {
			$this->aOppTeseo = null;
		}

	} 
	
	public function setOppTeseottId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->opp_teseott_id !== $v) {
			$this->opp_teseott_id = $v;
			$this->modifiedColumns[] = OppTeseoHasTeseottPeer::OPP_TESEOTT_ID;
		}

		if ($this->aOppTeseott !== null && $this->aOppTeseott->getId() !== $v) {
			$this->aOppTeseott = null;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->opp_teseo_id = $rs->getInt($startcol + 0);

			$this->opp_teseott_id = $rs->getInt($startcol + 1);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 2; 
		} catch (Exception $e) {
			throw new PropelException("Error populating OppTeseoHasTeseott object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(OppTeseoHasTeseottPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			OppTeseoHasTeseottPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(OppTeseoHasTeseottPeer::DATABASE_NAME);
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


												
			if ($this->aOppTeseo !== null) {
				if ($this->aOppTeseo->isModified()) {
					$affectedRows += $this->aOppTeseo->save($con);
				}
				$this->setOppTeseo($this->aOppTeseo);
			}

			if ($this->aOppTeseott !== null) {
				if ($this->aOppTeseott->isModified()) {
					$affectedRows += $this->aOppTeseott->save($con);
				}
				$this->setOppTeseott($this->aOppTeseott);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = OppTeseoHasTeseottPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setNew(false);
				} else {
					$affectedRows += OppTeseoHasTeseottPeer::doUpdate($this, $con);
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


												
			if ($this->aOppTeseo !== null) {
				if (!$this->aOppTeseo->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOppTeseo->getValidationFailures());
				}
			}

			if ($this->aOppTeseott !== null) {
				if (!$this->aOppTeseott->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOppTeseott->getValidationFailures());
				}
			}


			if (($retval = OppTeseoHasTeseottPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppTeseoHasTeseottPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getOppTeseoId();
				break;
			case 1:
				return $this->getOppTeseottId();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppTeseoHasTeseottPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getOppTeseoId(),
			$keys[1] => $this->getOppTeseottId(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppTeseoHasTeseottPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setOppTeseoId($value);
				break;
			case 1:
				$this->setOppTeseottId($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppTeseoHasTeseottPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setOppTeseoId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setOppTeseottId($arr[$keys[1]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(OppTeseoHasTeseottPeer::DATABASE_NAME);

		if ($this->isColumnModified(OppTeseoHasTeseottPeer::OPP_TESEO_ID)) $criteria->add(OppTeseoHasTeseottPeer::OPP_TESEO_ID, $this->opp_teseo_id);
		if ($this->isColumnModified(OppTeseoHasTeseottPeer::OPP_TESEOTT_ID)) $criteria->add(OppTeseoHasTeseottPeer::OPP_TESEOTT_ID, $this->opp_teseott_id);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(OppTeseoHasTeseottPeer::DATABASE_NAME);

		$criteria->add(OppTeseoHasTeseottPeer::OPP_TESEO_ID, $this->opp_teseo_id);
		$criteria->add(OppTeseoHasTeseottPeer::OPP_TESEOTT_ID, $this->opp_teseott_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getOppTeseoId();

		$pks[1] = $this->getOppTeseottId();

		return $pks;
	}

	
	public function setPrimaryKey($keys)
	{

		$this->setOppTeseoId($keys[0]);

		$this->setOppTeseottId($keys[1]);

	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{


		$copyObj->setNew(true);

		$copyObj->setOppTeseoId(NULL); 
		$copyObj->setOppTeseottId(NULL); 
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
			self::$peer = new OppTeseoHasTeseottPeer();
		}
		return self::$peer;
	}

	
	public function setOppTeseo($v)
	{


		if ($v === null) {
			$this->setOppTeseoId(NULL);
		} else {
			$this->setOppTeseoId($v->getId());
		}


		$this->aOppTeseo = $v;
	}


	
	public function getOppTeseo($con = null)
	{
				include_once 'lib/model/om/BaseOppTeseoPeer.php';

		if ($this->aOppTeseo === null && ($this->opp_teseo_id !== null)) {

			$this->aOppTeseo = OppTeseoPeer::retrieveByPK($this->opp_teseo_id, $con);

			
		}
		return $this->aOppTeseo;
	}

	
	public function setOppTeseott($v)
	{


		if ($v === null) {
			$this->setOppTeseottId(NULL);
		} else {
			$this->setOppTeseottId($v->getId());
		}


		$this->aOppTeseott = $v;
	}


	
	public function getOppTeseott($con = null)
	{
				include_once 'lib/model/om/BaseOppTeseottPeer.php';

		if ($this->aOppTeseott === null && ($this->opp_teseott_id !== null)) {

			$this->aOppTeseott = OppTeseottPeer::retrieveByPK($this->opp_teseott_id, $con);

			
		}
		return $this->aOppTeseott;
	}

} 