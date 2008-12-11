<?php
require_once(dirname(__FILE__).'/../../../../../plugins/deppPropelActAsBookmarkableBehaviorPlugin/modules/deppBookmarking/lib/BasedeppBookmarkingActions.class.php');

/**
 * deppBookmarking actions.
 *
 * @package    openparlamento
 * @subpackage deppBookmarking
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class deppBookmarkingActions extends BasedeppBookmarkingActions
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

    // go to error page if user is not monitoring the object (security)
    $this->forward404Unless($user->isMonitoring($item_model, $item_pk) || 
                            $user->isIndirectlyMonitoringAct($item_pk) ||
                            $this->item->hasBeenPositivelyBookmarked($this->user_id));
    
    // an object was bookmarked, clear the acts cache
    $cacheManager = $this->getContext()->getViewCacheManager();
    $user_token = $this->getUser()->getToken();
    $cacheManager->remove('monitoring/acts?user_token='.$user_token); 
    
  }
  
  public function executeNegativeBookmark()
  {
    parent::executeNegativeBookmark();
    $this->_clearNewsCache();
  }
  
  public function executeNegativeUnbookmark()
  {
    parent::executeNegativeUnbookmark();
    $this->_clearNewsCache();
  }
  
  protected function _clearNewsCache()
  {
    // an object was negatively bookmarked, clear the news cache (news of that object are no longer reported)
    $cacheManager = $this->getContext()->getViewCacheManager();
    $user_token = $this->getUser()->getToken();
    $cacheManager->remove('monitoring/news?user_token='.$user_token); 
  }
  
}
