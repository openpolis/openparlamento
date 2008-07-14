<?php


abstract class BaseOppSeduta extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $data;


	
	protected $numero;


	
	protected $ramo;


	
	protected $legislatura;

	
	protected $collOppVotaziones;

	
	protected $lastOppVotazioneCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
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

	
	public function getNumero()
	{

		return $this->numero;
	}

	
	public function getRamo()
	{

		return $this->ramo;
	}

	
	public function getLegislatura()
	{

		return $this->legislatura;
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = OppSedutaPeer::ID;
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
			$this->modifiedColumns[] = OppSedutaPeer::DATA;
		}

	} 
	
	public function setNumero($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->numero !== $v) {
			$this->numero = $v;
			$this->modifiedColumns[] = OppSedutaPeer::NUMERO;
		}

	} 
	
	public function setRamo($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->ramo !== $v) {
			$this->ramo = $v;
			$this->modifiedColumns[] = OppSedutaPeer::RAMO;
		}

	} 
	
	public function setLegislatura($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->legislatura !== $v) {
			$this->legislatura = $v;
			$this->modifiedColumns[] = OppSedutaPeer::LEGISLATURA;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->data = $rs->getDate($startcol + 1, null);

			$this->numero = $rs->getInt($startcol + 2);

			$this->ramo = $rs->getString($startcol + 3);

			$this->legislatura = $rs->getInt($startcol + 4);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 5; 
		} catch (Exception $e) {
			throw new PropelException("Error populating OppSeduta object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(OppSedutaPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			OppSedutaPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(OppSedutaPeer::DATABASE_NAME);
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


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = OppSedutaPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += OppSedutaPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collOppVotaziones !== null) {
				foreach($this->collOppVotaziones as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

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


			if (($retval = OppSedutaPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collOppVotaziones !== null) {
					foreach($this->collOppVotaziones as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}


			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppSedutaPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getData();
				break;
			case 2:
				return $this->getNumero();
				break;
			case 3:
				return $this->getRamo();
				break;
			case 4:
				return $this->getLegislatura();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppSedutaPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getData(),
			$keys[2] => $this->getNumero(),
			$keys[3] => $this->getRamo(),
			$keys[4] => $this->getLegislatura(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppSedutaPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setData($value);
				break;
			case 2:
				$this->setNumero($value);
				break;
			case 3:
				$this->setRamo($value);
				break;
			case 4:
				$this->setLegislatura($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppSedutaPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setData($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setNumero($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setRamo($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setLegislatura($arr[$keys[4]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(OppSedutaPeer::DATABASE_NAME);

		if ($this->isColumnModified(OppSedutaPeer::ID)) $criteria->add(OppSedutaPeer::ID, $this->id);
		if ($this->isColumnModified(OppSedutaPeer::DATA)) $criteria->add(OppSedutaPeer::DATA, $this->data);
		if ($this->isColumnModified(OppSedutaPeer::NUMERO)) $criteria->add(OppSedutaPeer::NUMERO, $this->numero);
		if ($this->isColumnModified(OppSedutaPeer::RAMO)) $criteria->add(OppSedutaPeer::RAMO, $this->ramo);
		if ($this->isColumnModified(OppSedutaPeer::LEGISLATURA)) $criteria->add(OppSedutaPeer::LEGISLATURA, $this->legislatura);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(OppSedutaPeer::DATABASE_NAME);

		$criteria->add(OppSedutaPeer::ID, $this->id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setData($this->data);

		$copyObj->setNumero($this->numero);

		$copyObj->setRamo($this->ramo);

		$copyObj->setLegislatura($this->legislatura);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getOppVotaziones() as $relObj) {
				$copyObj->addOppVotazione($relObj->copy($deepCopy));
			}

		} 

		$copyObj->setNew(true);

		$copyObj->setId(NULL); 
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
			self::$peer = new OppSedutaPeer();
		}
		return self::$peer;
	}

	
	public function initOppVotaziones()
	{
		if ($this->collOppVotaziones === null) {
			$this->collOppVotaziones = array();
		}
	}

	
	public function getOppVotaziones($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppVotazionePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppVotaziones === null) {
			if ($this->isNew()) {
			   $this->collOppVotaziones = array();
			} else {

				$criteria->add(OppVotazionePeer::SEDUTA_ID, $this->getId());

				OppVotazionePeer::addSelectColumns($criteria);
				$this->collOppVotaziones = OppVotazionePeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(OppVotazionePeer::SEDUTA_ID, $this->getId());

				OppVotazionePeer::addSelectColumns($criteria);
				if (!isset($this->lastOppVotazioneCriteria) || !$this->lastOppVotazioneCriteria->equals($criteria)) {
					$this->collOppVotaziones = OppVotazionePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastOppVotazioneCriteria = $criteria;
		return $this->collOppVotaziones;
	}

	
	public function countOppVotaziones($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseOppVotazionePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(OppVotazionePeer::SEDUTA_ID, $this->getId());

		return OppVotazionePeer::doCount($criteria, $distinct, $con);
	}

	
	public function addOppVotazione(OppVotazione $l)
	{
		$this->collOppVotaziones[] = $l;
		$l->setOppSeduta($this);
	}

} 