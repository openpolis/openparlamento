<?php

/**
 * monitoring actions.
 *
 * @package    openparlamento
 * @subpackage monitoring
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class monitoringActions extends sfActions
{
  /**
   * Executes index action
   *
   */
  public function executeIndex()
  {
    $this->forward('monitoring', 'tags');
  }
  
  public function executeTags()
  {
    // embed javascripts for edit-in-place and auto-completer
    $response = sfContext::getInstance()->getResponse();
    $response->addJavascript('prototype.js');
    $response->addJavascript('effects.js');
    $response->addJavascript('controls.js');
    
    // fetch current user profile
    $this->opp_user = OppUserPeer::retrieveByPK($this->getUser()->getId());
    sflogger::getInstance()->info('xxx: ' . $this->opp_user->getId());   
 
    // fetch teseo top_terms
    $this->teseo_tts = OppTeseottPeer::doSelect(new Criteria());
    
    // fetch tags I am monitoring
    $this->my_tags = self:: _getMyTags($this->getUser()->getId());
  }
  
  public function executeAjaxTagsForTopTerm()
  {
    $isAjax = $this->getRequest()->isXmlHttpRequest();
    if (!$isAjax) return sfView::noAjax;

    $this->my_tags = self::_getMyTags($this->getUser()->getId());
    
    $top_term_id = $this->getRequestParameter('tt_id');
    $this->tags = OppTeseottPeer::retrieveTagsFromTTPK($top_term_id);
  }

  public function executeAjaxAddTagToMyMonitoredTags()
  {
    $isAjax = $this->getRequest()->isXmlHttpRequest();
    if (!$isAjax) return sfView::noAjax;

    // fetch current user profile
    $opp_user = OppUserPeer::retrieveByPK($this->getUser()->getId());
    
    // check if the user can add a new tag to the monitored pool
    $this->remaining_tags = $opp_user->getNMaxMonitorables() - $opp_user->getNMonitoredObjects();
    if ($this->remaining_tags == 0){
      $this->renderText('Hai terminato i tag monitorabili, acquistane di più!');
      return sfView::NONE;
    }

    // add the tag to the monitored pool
    $tag_id = $this->getRequestParameter('tag_id');
    $tag = TagPeer::retrieveByPK($tag_id);
    $tag->addMonitoring($this->getUser()->getId());

    // decrease the number of tags the user can add
    $this->remaining_tags --;
    
    // fetch the monitored pool
    $this->my_tags = self::_getMyTags($this->getUser()->getId());
    $this->setTemplate('ajaxMyTags');
  }

  public function executeAjaxRemoveTagFromMyMonitoredTags()
  {
    $isAjax = $this->getRequest()->isXmlHttpRequest();
    if (!$isAjax) return sfView::noAjax;

    // remove the tag from the monitored pool
    $tag_id = $this->getRequestParameter('tag_id');
    $tag = TagPeer::retrieveByPK($tag_id);
    $tag->removeMonitoring($this->getUser()->getId());

    // fetch current user profile and the number of tags the user can still add to the pool
    $opp_user = OppUserPeer::retrieveByPK($this->getUser()->getId());
    $this->remaining_tags = $opp_user->getNMaxMonitorables() - $opp_user->getNMonitoredObjects();

    // fetch the monitored pool
    $this->my_tags = self::_getMyTags($this->getUser()->getId());
    $this->setTemplate('ajaxMyTags');
  }


  // fetch tags I am monitoring
  protected static function _getMyTags($user_id)
  {
    // fetch tags I am monitoring
    $c = new Criteria();
    $c->add(MonitoringPeer::MONITORABLE_MODEL, 'Tag');
    return deppPropelActAsMonitorableBehavior::getMonitoredObjects($user_id, $c);    
  }
  

}
