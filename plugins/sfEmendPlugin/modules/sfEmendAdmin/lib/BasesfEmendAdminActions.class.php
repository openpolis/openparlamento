<?php

/**
 * BasedsfEmendAdmin actions
 *
 * @package    plugins
 * @subpackage sfEmendPlugin/sfEmendAdmin
 * @author     
 */
class BasesfEmendAdminActions extends autoSfEmendAdminActions
{
  public function preExecute()
  {
    $response = sfContext::getInstance()->getResponse();
    $css = '/sfEmendPlugin/css/admin';
    $response->addStylesheet($css);
  }
  
  
  
  public function executeTogglePublish()
  {    
    $comment_id = $this->getRequestParameter('id');
    $comment = sfEmendCommentPeer::retrieveByPk($comment_id);
    $this->forward404Unless($comment);
    
    // toggle publish state
    if ($comment->getIsPublic())
      $comment->setIsPublic(0);
    else
      $comment->setIsPublic(1);
    
    $comment->save();
    

    if($referer = $this->getRequest()->getReferer())
    {
      $this->redirect($referer);
    }
    else
    {
      $this->redirect('sfEmendAdmin/list');
    }
  }
  
    
}
