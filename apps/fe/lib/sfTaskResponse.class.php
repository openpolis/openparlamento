<?php
/**
 * sfTaskResponse provides methods for manipulating client response in cli environment, while running tasks.
 * It's useful when sending emails via a batch process.
 * In factories.yml, you must define a task: environment and 
 *
 * @package    symfony
 * @subpackage response
 * @author     Guglielmo Celata <guglielmo.clata@gmail.com>
 */
class sfTaskResponse extends sfResponse
{
  /**
   * Executes the shutdown procedure.
   *
   */
  public function shutdown()
  {
  }
  
  public function getContentType()
  {
  }
  
  public function addHttpMeta()
  {
  }

  public function addMeta()
  {
  }

  public function addStylesheet()
  {
  }
  
}
