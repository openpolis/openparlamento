<?php
/*
 * This file is part of the deppPropelActAsPrioritisableBehavior package.
 *
 * (c) 2010 Guglielmo Celata <guglielmo.celata@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
?>

<?php
/**
 * deppPropelActAsPrioritisableBehaviorPlugin exception
 * 
 * @package    plugins
 * @subpackage prioritising 
 * @author     Guglielmo Celata <guglielmo.celata@gmail.com> 
 */
class deppPropelActAsPrioritisableException extends sfException 
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
      $this->setName('deppPropelActAsPrioritisableException');
    }

    parent::__construct($message, $code);
  }

}
