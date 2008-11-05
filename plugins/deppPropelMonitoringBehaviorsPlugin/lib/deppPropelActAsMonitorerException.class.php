<?php
/*
 * This file is part of the deppPropelMonitoringBehaviors package.
 *
 * (c) 2008 Guglielmo Celata <guglielmo.celata@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
?>
<?php
/**
 * deppPropelActAsMonitorerBehaviorPlugin exception
 * 
 * @package    plugins
 * @subpackage voting 
 * @author     Guglielmo Celata <guglielmo.celata@gmail.com> 
 */
class deppPropelActAsMonitorerException extends sfException 
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
      $this->setName('deppPropelActAsMonitorerException');
    }

    parent::__construct($message, $code);
  }

}
