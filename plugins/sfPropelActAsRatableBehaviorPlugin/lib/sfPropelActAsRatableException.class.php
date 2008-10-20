<?php
/*
 * This file is part of the sfPropelActAsRatableBehavior package.
 *
 * (c) 2007 Nicolas Perriault <nperriault@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


/**
 * sfPropelActAsRatableBehaviorPlugin exception
 * 
 * @package    plugins
 * @subpackage rating 
 * @author     Nicolas Perriault <nperriault@gmail.com> 
 */
class sfPropelActAsRatableException extends sfException 
{

  /**
   * Class constructor.
   *
   * @param string The error message
   * @param int    The error code
   */
  public function __construct($message = null, $code = 0)
  {
    if ($this->getName() === null)
    {
      $this->setName('sfPropelActAsRatableException');
    }

    parent::__construct($message, $code);
  }

}
