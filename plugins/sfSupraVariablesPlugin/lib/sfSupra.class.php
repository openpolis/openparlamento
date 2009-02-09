<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * sfSupraVariables - A Symfony Plugin for storing application variables
 *
 * This file is part of the sfSupraVariables package.
 * (c) 2009 Guglielmo Celata <g.celata => depp.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP versions 5
 */


/**
 * sfSupra is the core class of sfSupraVariables plugin.
 *
 * @category        Plugins
 * @package         sfSupraVAriables
 * @author          Guglielmo Celata <g.celata => depp.it>
 * @copyright       2009 Guglielmo Celata
 */
class sfSupra
{
  const IS_STRING = 0;
  const IS_INTEGER = 1;
  const IS_FLOAT = 2;
  const IS_BOOLEAN = 3;
  const IS_COMPLEX = 4;
  
  
  public static function setVariable($name, $value)
  {
    // check if variable exists
    $v = SupraPeer::retrieveByName($name);
    if (is_null($v))
    {
      $v = new Supra();
      $v->setName($name);      
    }
    
    if (is_string($value)) 
    {
      $type = self::IS_STRING;
      $v->setValue($value);
    } elseif (is_int($value)) {
      $type = self::IS_INTEGER; 
      $v->setValue( (int) $value);
    } elseif (is_float($value)) {
      $type = self::IS_FLOAT; 
      $v->setValue( (float) $value);
    } elseif (is_bool($value)) {
      $type = self::IS_BOOLEAN;
      $v->setValue( (bool) $value);
    } else {
      $type = self::IS_COMPLEX; 
      $v->setValue(serialize($value));
    }
    
    $v->setType($type);
    $v->save();    
  }
  
  public static function getVariable($name)
  {
    $var = SupraPeer::retrieveByName($name);
    if (is_null($var)) return null;

    switch ($var->getType())
    {
      case self::IS_INTEGER:
        $value = (int) $var->getValue();
        break;
        
      case self::IS_FLOAT:
        $value = (float) $var->getValue();
        break;
      
      case self::IS_STRING:
        $value = (string) $var->getValue();
        break;
        
      case self::IS_BOOLEAN:
        $value = (boolean) $var->getValue();
        break;
        
      case self::IS_COMPLEX:
        $value = unserialize($var->getValue());
        break;
    }
    return $value;
    
  }
  
}


/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */
