<?php

/**
 * Subclass for performing query and update operations on the 'sf_supra_variable' table.
 *
 * 
 *
 * @package plugins.sfSupraVariablesPlugin.lib.model
 */ 
class SupraPeer extends BaseSupraPeer
{
  public static function retrieveByName($name, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(SupraPeer::DATABASE_NAME);

		$criteria->add(SupraPeer::NAME, $name);


		$v = SupraPeer::doSelect($criteria, $con);

		return !empty($v) > 0 ? $v[0] : null;
	}
	
}
