<?php


abstract class BaseOppLegge extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $atto_id;


	
	protected $numero;


	
	protected $data;


	
	protected $url;


	
	protected $gu;

	
	protected $aOppAtto;

	
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

	
	public function getNumero()
	{

		return $this->numero;
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

	
	public function getUrl()
	{

		return $this->url;
	}

	
	public function getGu()
	{

		return $this->gu;
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = OppLeggePeer::ID;
		}

	} 
	
	public function setAttoId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->atto_id !== $v) {
			$this->atto_id = $v;
			$this->modifiedColumns[] = OppLeggePeer::ATTO_ID;
		}

		if ($this->aOppAtto !== null && $this->aOppAtto->getId() !== $v) {
			$this->aOppAtto = null;
		}

	} 
	
	public function setNumero($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->numero !== $v) {
			$this->numero = $v;
			$this->modifiedColumns[] = OppLeggePeer::NUMERO;
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
			$this->modifiedColumns[] = OppLeggePeer::DATA;
		}

	} 
	
	public function setUrl($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->url !== $v) {
			$this->url = $v;
			$this->modifiedColumns[] = OppLeggePeer::URL;
		}

	} 
	
	public function setGu($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->gu !== $v) {
			$this->gu = $v;
			$this->modifiedColumns[] = OppLeggePeer::GU;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->atto_id = $rs->getInt($startcol + 1);

			$this->numero = $rs->getInt($startcol + 2);

			$this->data = $rs->getDate($startcol + 3, null);

			$this->url = $rs->getString($startcol + 4);

			$this->gu = $rs->getString($startcol + 5);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 6; 
		} catch (Exception $e) {
			throw new PropelException("Error populating OppLegge object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(OppLeggePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			OppLeggePeer::doDelete($this, $con);
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
			$con = Propel::getConnection(OppLeggePeer::DATABASE_NAME);
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


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = OppLeggePeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += OppLeggePeer::doUpdate($this, $con);
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


			if (($retval = OppLeggePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppLeggePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getNumero();
				break;
			case 3:
				return $this->getData();
				break;
			case 4:
				return $this->getUrl();
				break;
			case 5:
				return $this->getGu();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppLeggePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getAttoId(),
			$keys[2] => $this->getNumero(),
			$keys[3] => $this->getData(),
			$keys[4] => $this->getUrl(),
			$keys[5] => $this->getGu(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppLeggePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setNumero($value);
				break;
			case 3:
				$this->setData($value);
				break;
			case 4:
				$this->setUrl($value);
				break;
			case 5:
				$this->setGu($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppLeggePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setAttoId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setNumero($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setData($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setUrl($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setGu($arr[$keys[5]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(OppLeggePeer::DATABASE_NAME);

		if ($this->isColumnModified(OppLeggePeer::ID)) $criteria->add(OppLeggePeer::ID, $this->id);
		if ($this->isColumnModified(OppLeggePeer::ATTO_ID)) $criteria->add(OppLeggePeer::ATTO_ID, $this->atto_id);
		if ($this->isColumnModified(OppLeggePeer::NUMERO)) $criteria->add(OppLeggePeer::NUMERO, $this->numero);
		if ($this->isColumnModified(OppLeggePeer::DATA)) $criteria->add(OppLeggePeer::DATA, $this->data);
		if ($this->isColumnModified(OppLeggePeer::URL)) $criteria->add(OppLeggePeer::URL, $this->url);
		if ($this->isColumnModified(OppLeggePeer::GU)) $criteria->add(OppLeggePeer::GU, $this->gu);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(OppLeggePeer::DATABASE_NAME);

		$criteria->add(OppLeggePeer::ID, $this->id);
		$criteria->add(OppLeggePeer::ATTO_ID, $this->atto_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getId();

		$pks[1] = $this->getAttoId();

		return $pks;
	}

	
	public function setPrimaryKey($keys)
	{

		$this->setId($keys[0]);

		$this->setAttoId($keys[1]);

	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setNumero($this->numero);

		$copyObj->setData($this->data);

		$copyObj->setUrl($this->url);

		$copyObj->setGu($this->gu);


		$copyObj->setNew(true);

		$copyObj->setId(NULL); 
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
			self::$peer = new OppLeggePeer();
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

} 