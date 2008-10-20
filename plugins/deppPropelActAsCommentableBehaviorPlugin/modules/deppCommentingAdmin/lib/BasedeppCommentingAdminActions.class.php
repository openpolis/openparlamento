<?php

/**
 * BasedeppCommentingAdmin actions
 *
 * @package    plugins
 * @subpackage deppPropelActAsCommentableBehaviorPlugin/deppCommentingAdmin
 * @author     
 */
class BasedeppCommentingAdminActions extends autoDeppCommentingAdminActions
{
  public function preExecute()
  {
    $response = sfContext::getInstance()->getResponse();
    $css = '/deppPropelActAsCommentableBehaviorPlugin/css/depp_commenting_admin';
    $response->addStylesheet($css);
  }
  
  
  
  public function executeTogglePublish()
  {
    
    $comment_id = $this->getRequestParameter('id');
    $comment = sfCommentPeer::retrieveByPk($comment_id);
    $this->forward404Unless($comment);
    
    // retrieve commentable object from comment
    $commentable_peer = $comment->getCommentableModel() . 'Peer';
    $commentable_id = $comment->getCommentableId();
    $commentable_object = call_user_func(array($commentable_peer, 'retrieveByPK'), $commentable_id);

    // toggle publish state using the behavior API
    if ($comment->getIsPublic())
      $commentable_object->unpublishComment($comment_id);
    else
      $commentable_object->publishComment($comment_id);

    if($this->getRequestParameter('from_email') == 1)
    {
      $this->comment = $comment;
      return sfView::SUCCESS;
    }
    
    if($referer = $this->getRequest()->getReferer())
    {
      $this->redirect($referer);
    }
    else
    {
      $this->redirect('deppCommentingAdmin/list');
    }
  }
  
  
  /**
   * overrides the deletesfComment created by the generator
   * a comment is removed, using the behavior API, so that
   * the count cache is kept valid
   *
   * @return void
   * @author Guglielmo Celata
   **/
  protected function deletesfComment($comment)
  {
    // retrieve commentable object from comment
    $commentable_peer = $comment->getCommentableModel() . 'Peer';
    $commentable_id = $comment->getCommentableId();
    $commentable_object = call_user_func(array($commentable_peer, 'retrieveByPK'), $commentable_id);

    // API comment removal
    $commentable_object->removeComment($comment->getId());
  }
  
  
  
}
