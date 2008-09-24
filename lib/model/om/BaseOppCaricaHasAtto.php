<?php


abstract class BaseOppCaricaHasAtto extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $atto_id;


	
	protected $carica_id;


	
	protected $tipo;


	
	protected $data;


	
	protected $url;

	
	protected $aOppAtto;

	
	protected $aOppCarica;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getAttoId()
	{

		return $this->atto_id;
	}

	
	public function getCaricaId()
	{

		return $this->carica_id;
	}

	
	public function getTipo()
	{

		return $this->tipo;
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

	
	public function setAttoId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->atto_id !== $v) {
			$this->atto_id = $v;
			$this->modifiedColumns[] = OppCaricaHasAttoPeer::ATTO_ID;
		}

		if ($this->aOppAtto !== null && $this->aOppAtto->getId() !== $v) {
			$this->aOppAtto = null;
		}

	} 
	
	public function setCaricaId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->carica_id !== $v) {
			$this->carica_id = $v;
			$this->modifiedColumns[] = OppCaricaHasAttoPeer::CARICA_ID;
		}

		if ($this->aOppCarica !== null && $this->aOppCarica->getId() !== $v) {
			$this->aOppCarica = null;
		}

	} 
	
	public function setTipo($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->tipo !== $v) {
			$this->tipo = $v;
			$this->modifiedColumns[] = OppCaricaHasAttoPeer::TIPO;
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
			$this->modifiedColumns[] = OppCaricaHasAttoPeer::DATA;
		}

	} 
	
	public function setUrl($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->url !== $v) {
			$this->url = $v;
			$this->modifiedColumns[] = OppCaricaHasAttoPeer::URL;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->atto_id = $rs->getInt($startcol + 0);

			$this->carica_id = $rs->getInt($startcol + 1);

			$this->tipo = $rs->getString($startcol + 2);

			$this->data = $rs->getDate($startcol + 3, null);

			$this->url = $rs->getString($startcol + 4);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 5; 
		} catch (Exception $e) {
			throw new PropelException("Error populating OppCaricaHasAtto object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(OppCaricaHasAttoPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			OppCaricaHasAttoPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(OppCaricaHasAttoPeer::DATABASE_NAME);
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

			if ($this->aOppCarica !== null) {
				if ($this->aOppCarica->isModified()) {
					$affectedRows += $this->aOppCarica->save($con);
				}
				$this->setOppCarica($this->aOppCarica);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = OppCaricaHasAttoPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setNew(false);
				} else {
					$affectedRows += OppCaricaHasAttoPeer::doUpdate($this, $con);
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

			if ($this->aOppCarica !== null) {
				if (!$this->aOppCarica->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOppCarica->getValidationFailures());
				}
			}


			if (($retval = OppCaricaHasAttoPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppCaricaHasAttoPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getAttoId();
				break;
			case 1:
				return $this->getCaricaId();
				break;
			case 2:
				return $this->getTipo();
				break;
			case 3:
				return $this->getData();
				break;
			case 4:
				return $this->getUrl();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppCaricaHasAttoPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getAttoId(),
			$keys[1] => $this->getCaricaId(),
			$keys[2] => $this->getTipo(),
			$keys[3] => $this->getData(),
			$keys[4] => $this->getUrl(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppCaricaHasAttoPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setAttoId($value);
				break;
			case 1:
				$this->setCaricaId($value);
				break;
			case 2:
				$this->setTipo($value);
				break;
			case 3:
				$this->setData($value);
				break;
			case 4:
				$this->setUrl($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppCaricaHasAttoPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setAttoId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setCaricaId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setTipo($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setData($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setUrl($arr[$keys[4]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(OppCaricaHasAttoPeer::DATABASE_NAME);

		if ($this->isColumnModified(OppCaricaHasAttoPeer::ATTO_ID)) $criteria->add(OppCaricaHasAttoPeer::ATTO_ID, $this->atto_id);
		if ($this->isColumnModified(OppCaricaHasAttoPeer::CARICA_ID)) $criteria->add(OppCaricaHasAttoPeer::CARICA_ID, $this->carica_id);
		if ($this->isColumnModified(OppCaricaHasAttoPeer::TIPO)) $criteria->add(OppCaricaHasAttoPeer::TIPO, $this->tipo);
		if ($this->isColumnModified(OppCaricaHasAttoPeer::DATA)) $criteria->add(OppCaricaHasAttoPeer::DATA, $this->data);
		if ($this->isColumnModified(OppCaricaHasAttoPeer::URL)) $criteria->add(OppCaricaHasAttoPeer::URL, $this->url);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(OppCaricaHasAttoPeer::DATABASE_NAME);

		$criteria->add(OppCaricaHasAttoPeer::ATTO_ID, $this->atto_id);
		$criteria->add(OppCaricaHasAttoPeer::CARICA_ID, $this->carica_id);
		$criteria->add(OppCaricaHasAttoPeer::TIPO, $this->tipo);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getAttoId();

		$pks[1] = $this->getCaricaId();

		$pks[2] = $this->getTipo();

		return $pks;
	}

	
	public function setPrimaryKey($keys)
	{

		$this->setAttoId($keys[0]);

		$this->setCaricaId($keys[1]);

		$this->setTipo($keys[2]);

	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setData($this->data);

		$copyObj->setUrl($this->url);


		$copyObj->setNew(true);

		$copyObj->setAttoId(NULL); 
		$copyObj->setCaricaId(NULL); 
		$copyObj->setTipo(NULL); 
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
			self::$peer = new OppCaricaHasAttoPeer();
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