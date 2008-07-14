<?php


abstract class BaseOppCaricaHasDdl extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $ddl_id;


	
	protected $carica_id;


	
	protected $tipo;


	
	protected $data;


	
	protected $url;

	
	protected $aOppDdl;

	
	protected $aOppCarica;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getDdlId()
	{

		return $this->ddl_id;
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

	
	public function setDdlId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->ddl_id !== $v) {
			$this->ddl_id = $v;
			$this->modifiedColumns[] = OppCaricaHasDdlPeer::DDL_ID;
		}

		if ($this->aOppDdl !== null && $this->aOppDdl->getId() !== $v) {
			$this->aOppDdl = null;
		}

	} 
	
	public function setCaricaId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->carica_id !== $v) {
			$this->carica_id = $v;
			$this->modifiedColumns[] = OppCaricaHasDdlPeer::CARICA_ID;
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
			$this->modifiedColumns[] = OppCaricaHasDdlPeer::TIPO;
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
			$this->modifiedColumns[] = OppCaricaHasDdlPeer::DATA;
		}

	} 
	
	public function setUrl($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->url !== $v) {
			$this->url = $v;
			$this->modifiedColumns[] = OppCaricaHasDdlPeer::URL;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->ddl_id = $rs->getInt($startcol + 0);

			$this->carica_id = $rs->getInt($startcol + 1);

			$this->tipo = $rs->getString($startcol + 2);

			$this->data = $rs->getDate($startcol + 3, null);

			$this->url = $rs->getString($startcol + 4);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 5; 
		} catch (Exception $e) {
			throw new PropelException("Error populating OppCaricaHasDdl object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(OppCaricaHasDdlPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			OppCaricaHasDdlPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(OppCaricaHasDdlPeer::DATABASE_NAME);
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

			if ($this->aOppCarica !== null) {
				if ($this->aOppCarica->isModified()) {
					$affectedRows += $this->aOppCarica->save($con);
				}
				$this->setOppCarica($this->aOppCarica);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = OppCaricaHasDdlPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setNew(false);
				} else {
					$affectedRows += OppCaricaHasDdlPeer::doUpdate($this, $con);
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

			if ($this->aOppCarica !== null) {
				if (!$this->aOppCarica->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOppCarica->getValidationFailures());
				}
			}


			if (($retval = OppCaricaHasDdlPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppCaricaHasDdlPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getDdlId();
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
		$keys = OppCaricaHasDdlPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getDdlId(),
			$keys[1] => $this->getCaricaId(),
			$keys[2] => $this->getTipo(),
			$keys[3] => $this->getData(),
			$keys[4] => $this->getUrl(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppCaricaHasDdlPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setDdlId($value);
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
		$keys = OppCaricaHasDdlPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setDdlId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setCaricaId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setTipo($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setData($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setUrl($arr[$keys[4]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(OppCaricaHasDdlPeer::DATABASE_NAME);

		if ($this->isColumnModified(OppCaricaHasDdlPeer::DDL_ID)) $criteria->add(OppCaricaHasDdlPeer::DDL_ID, $this->ddl_id);
		if ($this->isColumnModified(OppCaricaHasDdlPeer::CARICA_ID)) $criteria->add(OppCaricaHasDdlPeer::CARICA_ID, $this->carica_id);
		if ($this->isColumnModified(OppCaricaHasDdlPeer::TIPO)) $criteria->add(OppCaricaHasDdlPeer::TIPO, $this->tipo);
		if ($this->isColumnModified(OppCaricaHasDdlPeer::DATA)) $criteria->add(OppCaricaHasDdlPeer::DATA, $this->data);
		if ($this->isColumnModified(OppCaricaHasDdlPeer::URL)) $criteria->add(OppCaricaHasDdlPeer::URL, $this->url);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(OppCaricaHasDdlPeer::DATABASE_NAME);

		$criteria->add(OppCaricaHasDdlPeer::DDL_ID, $this->ddl_id);
		$criteria->add(OppCaricaHasDdlPeer::CARICA_ID, $this->carica_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getDdlId();

		$pks[1] = $this->getCaricaId();

		return $pks;
	}

	
	public function setPrimaryKey($keys)
	{

		$this->setDdlId($keys[0]);

		$this->setCaricaId($keys[1]);

	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setTipo($this->tipo);

		$copyObj->setData($this->data);

		$copyObj->setUrl($this->url);


		$copyObj->setNew(true);

		$copyObj->setDdlId(NULL); 
		$copyObj->setCaricaId(NULL); 
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
			self::$peer = new OppCaricaHasDdlPeer();
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