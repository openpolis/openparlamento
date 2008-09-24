<?php


abstract class BaseOppTipoTeseo extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $tipo;

	
	protected $collOppTeseos;

	
	protected $lastOppTeseoCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getTipo()
	{

		return $this->tipo;
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = OppTipoTeseoPeer::ID;
		}

	} 
	
	public function setTipo($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->tipo !== $v) {
			$this->tipo = $v;
			$this->modifiedColumns[] = OppTipoTeseoPeer::TIPO;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->tipo = $rs->getString($startcol + 1);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 2; 
		} catch (Exception $e) {
			throw new PropelException("Error populating OppTipoTeseo object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(OppTipoTeseoPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			OppTipoTeseoPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(OppTipoTeseoPeer::DATABASE_NAME);
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
					$pk = OppTipoTeseoPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += OppTipoTeseoPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collOppTeseos !== null) {
				foreach($this->collOppTeseos as $referrerFK) {
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


			if (($retval = OppTipoTeseoPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collOppTeseos !== null) {
					foreach($this->collOppTeseos as $referrerFK) {
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
		$pos = OppTipoTeseoPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getTipo();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppTipoTeseoPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getTipo(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppTipoTeseoPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setTipo($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppTipoTeseoPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setTipo($arr[$keys[1]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(OppTipoTeseoPeer::DATABASE_NAME);

		if ($this->isColumnModified(OppTipoTeseoPeer::ID)) $criteria->add(OppTipoTeseoPeer::ID, $this->id);
		if ($this->isColumnModified(OppTipoTeseoPeer::TIPO)) $criteria->add(OppTipoTeseoPeer::TIPO, $this->tipo);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(OppTipoTeseoPeer::DATABASE_NAME);

		$criteria->add(OppTipoTeseoPeer::ID, $this->id);

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

		$copyObj->setTipo($this->tipo);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getOppTeseos() as $relObj) {
				$copyObj->addOppTeseo($relObj->copy($deepCopy));
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
			self::$peer = new OppTipoTeseoPeer();
		}
		return self::$peer;
	}

	
	public function initOppTeseos()
	{
		if ($this->collOppTeseos === null) {
			$this->collOppTeseos = array();
		}
	}

	
	public function getOppTeseos($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppTeseoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppTeseos === null) {
			if ($this->isNew()) {
			   $this->collOppTeseos = array();
			} else {

				$criteria->add(OppTeseoPeer::TIPO_TESEO_ID, $this->getId());

				OppTeseoPeer::addSelectColumns($criteria);
				$this->collOppTeseos = OppTeseoPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(OppTeseoPeer::TIPO_TESEO_ID, $this->getId());

				OppTeseoPeer::addSelectColumns($criteria);
				if (!isset($this->lastOppTeseoCriteria) || !$this->lastOppTeseoCriteria->equals($criteria)) {
					$this->collOppTeseos = OppTeseoPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastOppTeseoCriteria = $criteria;
		return $this->collOppTeseos;
	}

	
	public function countOppTeseos($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseOppTeseoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(OppTeseoPeer::TIPO_TESEO_ID, $this->getId());

		return OppTeseoPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addOppTeseo(OppTeseo $l)
	{
		$this->collOppTeseos[] = $l;
		$l->setOppTipoTeseo($this);
	}


	
	public function getOppTeseosJoinOppTeseott($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppTeseoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppTeseos === null) {
			if ($this->isNew()) {
				$this->collOppTeseos = array();
			} else {

				$criteria->add(OppTeseoPeer::TIPO_TESEO_ID, $this->getId());

				$this->collOppTeseos = OppTeseoPeer::doSelectJoinOppTeseott($criteria, $con);
			}
		} else {
									
			$criteria->add(OppTeseoPeer::TIPO_TESEO_ID, $this->getId());

			if (!isset($this->lastOppTeseoCriteria) || !$this->lastOppTeseoCriteria->equals($criteria)) {
				$this->collOppTeseos = OppTeseoPeer::doSelectJoinOppTeseott($criteria, $con);
			}
		}
		$this->lastOppTeseoCriteria = $criteria;

		return $this->collOppTeseos;
	}

} 