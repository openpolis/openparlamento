<?php


abstract class BaseOppAttoAsIter extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $atto_id;


	
	protected $iter_id;


	
	protected $data;

	
	protected $aOppAtto;

	
	protected $aOppIter;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
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

	
	public function setAttoId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->atto_id !== $v) {
			$this->atto_id = $v;
			$this->modifiedColumns[] = OppAttoAsIterPeer::ATTO_ID;
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
			$this->modifiedColumns[] = OppAttoAsIterPeer::ITER_ID;
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
			$this->modifiedColumns[] = OppAttoAsIterPeer::DATA;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->atto_id = $rs->getInt($startcol + 0);

			$this->iter_id = $rs->getInt($startcol + 1);

			$this->data = $rs->getDate($startcol + 2, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 3; 
		} catch (Exception $e) {
			throw new PropelException("Error populating OppAttoAsIter object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(OppAttoAsIterPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			OppAttoAsIterPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(OppAttoAsIterPeer::DATABASE_NAME);
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
					$pk = OppAttoAsIterPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setNew(false);
				} else {
					$affectedRows += OppAttoAsIterPeer::doUpdate($this, $con);
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


			if (($retval = OppAttoAsIterPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppAttoAsIterPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getAttoId();
				break;
			case 1:
				return $this->getIterId();
				break;
			case 2:
				return $this->getData();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppAttoAsIterPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getAttoId(),
			$keys[1] => $this->getIterId(),
			$keys[2] => $this->getData(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppAttoAsIterPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setAttoId($value);
				break;
			case 1:
				$this->setIterId($value);
				break;
			case 2:
				$this->setData($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppAttoAsIterPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setAttoId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setIterId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setData($arr[$keys[2]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(OppAttoAsIterPeer::DATABASE_NAME);

		if ($this->isColumnModified(OppAttoAsIterPeer::ATTO_ID)) $criteria->add(OppAttoAsIterPeer::ATTO_ID, $this->atto_id);
		if ($this->isColumnModified(OppAttoAsIterPeer::ITER_ID)) $criteria->add(OppAttoAsIterPeer::ITER_ID, $this->iter_id);
		if ($this->isColumnModified(OppAttoAsIterPeer::DATA)) $criteria->add(OppAttoAsIterPeer::DATA, $this->data);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(OppAttoAsIterPeer::DATABASE_NAME);

		$criteria->add(OppAttoAsIterPeer::ATTO_ID, $this->atto_id);
		$criteria->add(OppAttoAsIterPeer::ITER_ID, $this->iter_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getAttoId();

		$pks[1] = $this->getIterId();

		return $pks;
	}

	
	public function setPrimaryKey($keys)
	{

		$this->setAttoId($keys[0]);

		$this->setIterId($keys[1]);

	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setData($this->data);


		$copyObj->setNew(true);

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
			self::$peer = new OppAttoAsIterPeer();
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