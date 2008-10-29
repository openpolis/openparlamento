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
 
    // fetch teseo top_terms
    $this->teseo_tts = OppTeseottPeer::doSelect(new Criteria());
    
    // fetch tags I am monitoring
    $this->my_tags = self:: _getMyTags();
  }
  
  public function executeAjaxTagsForTopTerm()
  {
    $isAjax = $this->getRequest()->isXmlHttpRequest();
    if (!$isAjax) return sfView::noAjax;

    $this->my_tags = self::_getMyTags();
    
    $top_term_id = $this->getRequestParameter('tt_id');
    $this->tags = OppTeseottPeer::retrieveTagsFromTTPK($top_term_id);
  }

  public function executeAjaxAddTagToMyMonitoredTags()
  {
    $isAjax = $this->getRequest()->isXmlHttpRequest();
    if (!$isAjax) return sfView::noAjax;

    // fetch current user profile
    $opp_user = OppUserPeer::retrieveByPK($this->getUser()->getId());
    

    // fetch the tag to add
    $tag_id = $this->getRequestParameter('tag_id');
    $tag = TagPeer::retrieveByPK($tag_id);

    // check if the user can add a new tag to the monitored pool
    $this->remaining_tags = $opp_user->getNMaxMonitoredTags() - $opp_user->countMonitoredObjects('Tag');
    if ($this->remaining_tags == 0){
      $this->renderText('Hai terminato i tag monitorabili, acquistane di più!');
      return sfView::NONE;
    }

    // add the tag to the monitorable pool
    $tag->addMonitoringUser($this->getUser()->getId());

    // decrease the number of tags the user can add
    $this->remaining_tags --;
    
    // fetch the monitored pool
    $this->my_tags = self::_getMyTags();
    $this->setTemplate('ajaxMyTags');
  }

  public function executeAjaxRemoveTagFromMyMonitoredTags()
  {
    $isAjax = $this->getRequest()->isXmlHttpRequest();
    if (!$isAjax) return sfView::noAjax;

    // remove the tag from the monitored pool
    $tag_id = $this->getRequestParameter('tag_id');
    $tag = TagPeer::retrieveByPK($tag_id);
    $tag->removeMonitoringUser($this->getUser()->getId());

    // fetch current user profile and the number of tags the user can still add to the pool
    $opp_user = OppUserPeer::retrieveByPK($this->getUser()->getId());
    $this->remaining_tags = $opp_user->getNMaxMonitoredTags() - $opp_user->countMonitoredObjects('Tag');

    // fetch the monitored pool
    $this->my_tags = self::_getMyTags();
    $this->setTemplate('ajaxMyTags');
  }


  public function executeAjaxAddItemToMyMonitoredItems()
  {
    $isAjax = $this->getRequest()->isXmlHttpRequest();
    // if (!$isAjax) return sfView::noAjax;
    $this->item_model = $this->getRequestParameter('item_model');
    $this->item_pk = $this->getRequestParameter('item_pk');
    
    $user = OppUserPeer::retrieveByPK($this->getUser()->getId());
    
    
    // check limitations (unless unlimited (0))
    if ($user->getNMaxMonitoredItems() != 0)
    {
      $this->remaining_items = $user->getNMaxMonitoredItems() - 
                               $user->countMonitoredObjects('OppAtto') -
                               $user->countMonitoredObjects('OppPolitico');

      if ($this->remaining_items == 0){
        $this->renderText('Hai raggiunto il numero massimo di oggetti monitorabili, acquistane di più!');
        return sfView::NONE;
      }      
    }


    $is_monitoring = $user->isMonitoring($this->item_model, $this->item_pk);
    if (!$is_monitoring) 
    {
      $user->addMonitoredObject($this->item_model, $this->item_pk);
    }  
    $this->setTemplate('ajaxManageItem');
    
  }
  
  
  public function executeAjaxRemoveItemFromMyMonitoredItems()
  {
    $isAjax = $this->getRequest()->isXmlHttpRequest();
    // if (!$isAjax) return sfView::noAjax;
    
    $this->item_model = $this->getRequestParameter('item_model');
    $this->item_pk = $this->getRequestParameter('item_pk');

    $user = OppUserPeer::retrieveByPK($this->getUser()->getId());

    $is_monitoring = $user->isMonitoring($this->item_model, $this->item_pk);
    if ($is_monitoring) 
    {
      $user->removeMonitoredObject($this->item_model, $this->item_pk);
    }  
    $this->setTemplate('ajaxManageItem');
    
  }
  
  // fetch tags I am monitoring
  protected static function _getMyTags()
  {
    // fetch tags I am monitoring
    $opp_user = OppUserPeer::retrieveByPK(sfContext::getInstance()->getUser()->getId());
    return $opp_user->getMonitoredObjects('Tag');    
  }
  

}
