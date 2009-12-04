<?php
/**
 * deppPropelActAsCommentableBehaviorPlugin base actions.
 * 
 * @package    plugins
 * @subpackage deppPropelActAsCommentableBehaviorPlugin/deppCommenting
 */
class BasedeppCommentingActions extends sfActions
{
  /**
   * Executes index action
   *
   */
  public function executeIndex()
  {
    $this->forward('default', 'module');
  }
  
  public function validateAddComment()
  {
    $captcha = $this->getRequestParameter('captcha');
    $this->automoderation = $this->getUser()->getAttribute('automoderation', '', 'comment');
    $this->read_only = $this->getUser()->getAttribute('read_only', '', 'comment');
    
    if (!sfContext::getInstance()->getUser()->isAuthenticated() && $this->automoderation == 'captcha')
    {
      // The captcha field is required
      if (!$captcha)
      {
        $this->getRequest()->setError('captcha', "L'inserimento del captcha &egrave; obbligatorio");
        return false;
      }
      
      // Controllo del captcha
      $captchaValidator = new captchaValidator();
      $captchaValidator->initialize($this->getContext(), array(
        'error' => 'Dovresti specificare il captcha esatto',
      ));
      if (!$captchaValidator->execute($captcha, $error))
      {
        $this->getRequest()->setError('captcha', $error);
        return false;
      }
    }

    return true;
  }
  
   public function executeAddComment()
   {
    $this->forward404Unless(sfConfig::get('app_comments_enabled', true));
    $this->content = call_user_func($this->getUser()->getAttribute('content_peer', '', 'comment').'::retrieveByPk', 
                                    $this->getUser()->getAttribute('content_id', '', 'comment'));    
    $this->forward404Unless($this->content);

    // TODO: the auto-moderation functionality must be yet implemented
    $this->setFlash('add_comment', 'normal'); 

    if($url = $this->getRequestParameter('website', ''))
    {
      if(strpos($url, 'http://') !== 0)
      {
        $url = 'http://'.$url; 
      }
    }

    // add the comment to the object
    $this->content->addComment(array('text' => $this->getRequestParameter('text'),
                                     'author_name'    => $this->getRequestParameter('name'),
                                     'author_email'   => $this->getRequestParameter('email'),
                                     'author_website' => $url));

    
    // TODO: send notification of the new comment to an address
    /*
    $email_pref = sfConfig::get('app_comment_mail_alert', 1);
    if($email_pref == 1 || ($email_pref == 'moderated' && $comment->getIsModerated()))
    {
      $this->getRequest()->setAttribute('comment', $comment);
      $raw_email = $this->sendEmail('comment', 'notifyModeratorOnComment');  
      $this->logMessage($raw_email, 'debug');
    }
    */
    
    // remove session variables from comment namespace (save some values before)
    $this->automoderation = $this->getUser()->getAttribute('automoderation', '', 'comment');
    $this->read_only = $this->getUser()->getAttribute('read_only', '', 'comment');
    $this->original_url = $this->getUser()->getAttribute('original_url', '', 'comment');
    $retval = $this->getUser()->getParameterHolder()->removeNamespace('comment');
    // ritorno (AJAX) o redirect (non-Ajax)
    if($this->getRequest()->isXmlHttpRequest())
    {
      return 'Ajax';
    }
    else
    {
      $this->redirect($this->original_url."#comments");
    }

  }
  
  
  public function handleErrorAddComment()
  {
    $this->content = call_user_func($this->getUser()->getAttribute('content_peer', '', 'comment').'::retrieveByPk', 
                                      $this->getUser()->getAttribute('content_id', '', 'comment'));    
    $this->content_peer = $this->getUser()->getAttribute('content_peer', '', 'comment');
    $this->automoderation = $this->getUser()->getAttribute('automoderation', '', 'comment');
    $this->read_only = $this->getUser()->getAttribute('read_only', '', 'comment');
    $this->original_url = $this->getUser()->getAttribute('original_url', '', 'comment');
    $this->forward404Unless($this->content);

    if($this->getRequest()->isXmlHttpRequest())
    {
      return 'Ajax';
    }
    else
    {
      return sfView::SUCCESS;
    }

  }  

}
