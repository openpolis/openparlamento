<?php


abstract class BaseOppTipoCarica extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $nome;

	
	protected $collOppCaricas;

	
	protected $lastOppCaricaCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getNome()
	{

		return $this->nome;
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = OppTipoCaricaPeer::ID;
		}

	} 
	
	public function setNome($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->nome !== $v) {
			$this->nome = $v;
			$this->modifiedColumns[] = OppTipoCaricaPeer::NOME;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->nome = $rs->getString($startcol + 1);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 2; 
		} catch (Exception $e) {
			throw new PropelException("Error populating OppTipoCarica object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(OppTipoCaricaPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			OppTipoCaricaPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(OppTipoCaricaPeer::DATABASE_NAME);
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
					$pk = OppTipoCaricaPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += OppTipoCaricaPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collOppCaricas !== null) {
				foreach($this->collOppCaricas as $referrerFK) {
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


			if (($retval = OppTipoCaricaPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collOppCaricas !== null) {
					foreach($this->collOppCaricas as $referrerFK) {
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
		$pos = OppTipoCaricaPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getNome();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppTipoCaricaPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getNome(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppTipoCaricaPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setNome($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppTipoCaricaPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setNome($arr[$keys[1]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(OppTipoCaricaPeer::DATABASE_NAME);

		if ($this->isColumnModified(OppTipoCaricaPeer::ID)) $criteria->add(OppTipoCaricaPeer::ID, $this->id);
		if ($this->isColumnModified(OppTipoCaricaPeer::NOME)) $criteria->add(OppTipoCaricaPeer::NOME, $this->nome);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(OppTipoCaricaPeer::DATABASE_NAME);

		$criteria->add(OppTipoCaricaPeer::ID, $this->id);

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

		$copyObj->setNome($this->nome);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getOppCaricas() as $relObj) {
				$copyObj->addOppCarica($relObj->copy($deepCopy));
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
			self::$peer = new OppTipoCaricaPeer();
		}
		return self::$peer;
	}

	
	public function initOppCaricas()
	{
		if ($this->collOppCaricas === null) {
			$this->collOppCaricas = array();
		}
	}

	
	public function getOppCaricas($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppCaricaPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppCaricas === null) {
			if ($this->isNew()) {
			   $this->collOppCaricas = array();
			} else {

				$criteria->add(OppCaricaPeer::TIPO_CARICA_ID, $this->getId());

				OppCaricaPeer::addSelectColumns($criteria);
				$this->collOppCaricas = OppCaricaPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(OppCaricaPeer::TIPO_CARICA_ID, $this->getId());

				OppCaricaPeer::addSelectColumns($criteria);
				if (!isset($this->lastOppCaricaCriteria) || !$this->lastOppCaricaCriteria->equals($criteria)) {
					$this->collOppCaricas = OppCaricaPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastOppCaricaCriteria = $criteria;
		return $this->collOppCaricas;
	}

	
	public function countOppCaricas($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseOppCaricaPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(OppCaricaPeer::TIPO_CARICA_ID, $this->getId());

		return OppCaricaPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addOppCarica(OppCarica $l)
	{
		$this->collOppCaricas[] = $l;
		$l->setOppTipoCarica($this);
	}


	
	public function getOppCaricasJoinOppPolitico($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppCaricaPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppCaricas === null) {
			if ($this->isNew()) {
				$this->collOppCaricas = array();
			} else {

				$criteria->add(OppCaricaPeer::TIPO_CARICA_ID, $this->getId());

				$this->collOppCaricas = OppCaricaPeer::doSelectJoinOppPolitico($criteria, $con);
			}
		} else {
									
			$criteria->add(OppCaricaPeer::TIPO_CARICA_ID, $this->getId());

			if (!isset($this->lastOppCaricaCriteria) || !$this->lastOppCaricaCriteria->equals($criteria)) {
				$this->collOppCaricas = OppCaricaPeer::doSelectJoinOppPolitico($criteria, $con);
			}
		}
		$this->lastOppCaricaCriteria = $criteria;

		return $this->collOppCaricas;
	}

} 