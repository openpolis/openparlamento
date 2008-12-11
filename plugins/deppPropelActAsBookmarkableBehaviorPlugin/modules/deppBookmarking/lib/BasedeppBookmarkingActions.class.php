<?php
/**
 * deppPropelActAsBookmarkableBehaviorPlugin base actions.
 *
 * This is an easy User Interface to bookmark objects
 * After bookmarking (or unbookmarking), the flow is redirected to the referer
 *
 * If a more advanced UI is needed, then an override is required
 *
 * @package    plugins
 * @subpackage bookmarking 
 */
class BasedeppBookmarkingActions extends sfActions
{
  
  
  /**
   * pre-execution: 
   *  - get the request parameters, 
   *  - check if the user has the 'right' to bookmark, 
   *  - prepare variables
   */
  public function preExecute()
  {
    $item_model = $this->getRequestParameter('item_model');
    $item_pk = $this->getRequestParameter('item_pk');

    $this->user_id = deppPropelActAsBookmarkableToolkit::getUserId();
    $user = OppUserPeer::retrieveByPK($this->user_id);

    $this->item = deppPropelActAsBookmarkableToolkit::retrieveBookmarkableObject($item_model, $item_pk);
  }

  
  public function executePositiveBookmark()
  {
    $this->forward404Unless(!$this->item->hasBeenPositivelyBookmarked($this->user_id));
    $this->item->setPositiveBookmarking($this->user_id);    
  }
  
  public function executePositiveUnbookmark()
  {
    $this->forward404Unless($this->item->hasBeenPositivelyBookmarked($this->user_id));
    $this->item->removePositiveBookmarking($this->user_id);
  }
  
  public function executeNegativeBookmark()
  {
    $this->forward404Unless(!$this->item->hasBeenNegativelyBookmarked($this->user_id));
    $this->item->setNegativeBookmarking($this->user_id);
  }
  
  public function executeNegativeUnbookmark()
  {
    $this->forward404Unless($this->item->hasBeenNegativelyBookmarked($this->user_id));
    $this->item->removeNegativeBookmarking($this->user_id);
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
    // redirect back to referer
    $this->redirect($this->getRequest()->getReferer());        
  }
  
    
}
