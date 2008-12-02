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

    // go to error page if user is not monitoring the object (security)
    $this->forward404Unless($user->isMonitoring($item_model, $item_pk) || $user->isIndirectlyMonitoringAct($item_pk));

    $this->item = deppPropelActAsBookmarkableToolkit::retrieveBookmarkableObject($item_model, $item_pk);
  }
}
