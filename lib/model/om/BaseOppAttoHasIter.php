<?php


abstract class BaseOppAttoHasIter extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $atto_id;


	
	protected $iter_id;


	
	protected $data;

	
	protected $aOppAtto;

	
	protected $aOppIter;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getAttoId()
	{

		return $this->atto_id;
	}

	
	public function getIterId()
	{

		return $this->iter_id;
	}

	
	public function getData($format = 'Y-m-d')
	{

		if ($this->data === null || $this->data === '') {
			return null;
		} elseif (!is_int($this->data)) {
						$ts = strtotime($this->data);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [data] as date/time value: " . var_export($this->data, true));
			}
		} else {
			$ts = $this->data;
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
			$this->modifiedColumns[] = OppAttoHasIterPeer::ID;
		}

	} 
	
	public function setAttoId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->atto_id !== $v) {
			$this->atto_id = $v;
			$this->modifiedColumns[] = OppAttoHasIterPeer::ATTO_ID;
		}

		if ($this->aOppAtto !== null && $this->aOppAtto->getId() !== $v) {
			$this->aOppAtto = null;
		}

	} 
	
	public function setIterId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->iter_id !== $v) {
			$this->iter_id = $v;
			$this->modifiedColumns[] = OppAttoHasIterPeer::ITER_ID;
		}

		if ($this->aOppIter !== null && $this->aOppIter->getId() !== $v) {
			$this->aOppIter = null;
		}

	} 
	
	public function setData($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [data] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->data !== $ts) {
			$this->data = $ts;
			$this->modifiedColumns[] = OppAttoHasIterPeer::DATA;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->atto_id = $rs->getInt($startcol + 1);

			$this->iter_id = $rs->getInt($startcol + 2);

			$this->data = $rs->getDate($startcol + 3, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 4; 
		} catch (Exception $e) {
			throw new PropelException("Error populating OppAttoHasIter object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(OppAttoHasIterPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			OppAttoHasIterPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(OppAttoHasIterPeer::DATABASE_NAME);
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

			if ($this->aOppIter !== null) {
				if ($this->aOppIter->isModified()) {
					$affectedRows += $this->aOppIter->save($con);
				}
				$this->setOppIter($this->aOppIter);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = OppAttoHasIterPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += OppAttoHasIterPeer::doUpdate($this, $con);
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

			if ($this->aOppIter !== null) {
				if (!$this->aOppIter->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOppIter->getValidationFailures());
				}
			}


			if (($retval = OppAttoHasIterPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppAttoHasIterPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getAttoId();
				break;
			case 2:
				return $this->getIterId();
				break;
			case 3:
				return $this->getData();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppAttoHasIterPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getAttoId(),
			$keys[2] => $this->getIterId(),
			$keys[3] => $this->getData(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppAttoHasIterPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setAttoId($value);
				break;
			case 2:
				$this->setIterId($value);
				break;
			case 3:
				$this->setData($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppAttoHasIterPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setAttoId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setIterId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setData($arr[$keys[3]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(OppAttoHasIterPeer::DATABASE_NAME);

		if ($this->isColumnModified(OppAttoHasIterPeer::ID)) $criteria->add(OppAttoHasIterPeer::ID, $this->id);
		if ($this->isColumnModified(OppAttoHasIterPeer::ATTO_ID)) $criteria->add(OppAttoHasIterPeer::ATTO_ID, $this->atto_id);
		if ($this->isColumnModified(OppAttoHasIterPeer::ITER_ID)) $criteria->add(OppAttoHasIterPeer::ITER_ID, $this->iter_id);
		if ($this->isColumnModified(OppAttoHasIterPeer::DATA)) $criteria->add(OppAttoHasIterPeer::DATA, $this->data);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(OppAttoHasIterPeer::DATABASE_NAME);

		$criteria->add(OppAttoHasIterPeer::ID, $this->id);
		$criteria->add(OppAttoHasIterPeer::ATTO_ID, $this->atto_id);
		$criteria->add(OppAttoHasIterPeer::ITER_ID, $this->iter_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getId();

		$pks[1] = $this->getAttoId();

		$pks[2] = $this->getIterId();

		return $pks;
	}

	
	public function setPrimaryKey($keys)
	{

		$this->setId($keys[0]);

		$this->setAttoId($keys[1]);

		$this->setIterId($keys[2]);

	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setData($this->data);


		$copyObj->setNew(true);

		$copyObj->setId(NULL); 
		$copyObj->setAttoId(NULL); 
		$copyObj->setIterId(NULL); 
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
			self::$peer = new OppAttoHasIterPeer();
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

	
	public function setOppIter($v)
	{


		if ($v === null) {
			$this->setIterId(NULL);
		} else {
			$this->setIterId($v->getId());
		}


		$this->aOppIter = $v;
	}


	
	public function getOppIter($con = null)
	{
				include_once 'lib/model/om/BaseOppIterPeer.php';

		if ($this->aOppIter === null && ($this->iter_id !== null)) {

			$this->aOppIter = OppIterPeer::retrieveByPK($this->iter_id, $con);

			
		}
		return $this->aOppIter;
	}

} 