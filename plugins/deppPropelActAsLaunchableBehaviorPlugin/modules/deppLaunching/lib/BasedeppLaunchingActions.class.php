<?php
/**
 * deppPropelActAsLaunchableBehaviorPlugin base actions.
 *
 * This is an easy User Interface to launch objects
 * After launching (or unlaunching), the flow is redirected to the referer
 *
 * If a more advanced UI is needed, then an override is required
 *
 * @package    plugins
 * @subpackage launching 
 */
class BasedeppLaunchingActions extends sfActions
{
  
  /**
   * pre-execution: 
   *  - get the request parameters, 
   *  - prepare variables
   */
  public function preExecute()
  {
    $item_model = $this->getRequestParameter('item_model');
    $item_pk = $this->getRequestParameter('item_pk');
    $this->namespace = $this->getRequestParameter('namespace');
    $this->item = deppPropelActAsLaunchableToolkit::retrieveLaunchableObject($item_model, $item_pk);
  }

  
  public function executeLaunch()
  {
    $this->forward404Unless(!in_array($this->namespace, $this->item->hasBeenLaunched()));
    $this->item->setLaunching($this->namespace);    
  }
  
  public function executeRemove()
  {
    $this->forward404Unless(in_array($this->namespace, $this->item->hasBeenLaunched()));
    $this->item->removeLaunching($this->namespace);
  }

  public function executePriorityUp()
  {
    $this->forward404Unless(in_array($this->namespace, $this->item->hasBeenLaunched()));
    $this->item->increasePriority($this->namespace, $this->getRequestParameter('paths', 1) );

	return $this->resultAjaxSuccess();
  }

  public function executePriorityDn()
  {
    $this->forward404Unless(in_array($this->namespace, $this->item->hasBeenLaunched()));
    $this->item->decreasePriority($this->namespace, $this->getRequestParameter('paths', 1));

	return $this->resultAjaxSuccess();
  }

	private function resultAjaxSuccess()
	{
		if ( !$this->getRequest()->isXmlHttpRequest() )
		{
			return;
		}
		$this->setLayout(false);    
	    $this->response->setContent("");
		sfConfig::set('sf_web_debug', false);
		return sfView::NONE;
	}


  /**
   * post-execution
   *  - redirect to the referer page
   *
   * @return void
   * @author Guglielmo Celata
   **/
  public function postExecute()
  {
	if ( $this->getRequest()->isXmlHttpRequest() )
		return;
    // redirect back to referer
    $this->redirect($this->getRequest()->getReferer());        
  }
  
    
}
