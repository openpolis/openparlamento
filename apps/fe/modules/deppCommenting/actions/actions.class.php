<?php
require_once(dirname(__FILE__).'/../../../../../plugins/deppPropelActAsCommentableBehaviorPlugin/modules/deppCommenting/lib/BasedeppCommentingActions.class.php');

/**
 * deppPropelActAsCommentableBehaviorPlugin actions. 
 *
 * @package    plugins
 * @subpackage deppCommenting
 * @author     Guglielmo Celata
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class deppCommentingActions extends BasedeppCommentingActions
{
  /**
   * retrieve the commented object, starting from the comment
   * the details of the commentable objects need to be known
   * that's why this function lives in the deppCommenting actions
   *
   * @param string $comment 
   * @return Object
   * @author Guglielmo Celata
   */
  public static function retrieveObjectByComment($comment)
  {
    $c = new Criteria();
    switch ($comment->getCommentableModel()) {
      case 'OppAtto':
        $c->add(OppAttoPeer::ID, $comment->getCommentableId());
        break;
      case 'OppEmendamento':
        $c->add(OppEmendamentoPeer::ID, $comment->getCommentableId());
        break;
      case 'OppVotazione':
        $c->add(OppVotazionePeer::ID, $comment->getCommentableId());
        break;
    }
    return call_user_func($comment->getCommentableModel()."Peer::doSelectOne", $c);
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
    $comment_object = $this->content->addComment(array('text' => $this->getRequestParameter('text'),
                                                       'author_name'    => $this->getRequestParameter('name'),
                                                       'author_email'   => $this->getRequestParameter('mail'),
                                                       'author_website' => $url));

  
    // comments by non-auth users, containing href are unpublished by default
    $commented_object = self::retrieveObjectByComment($comment_object);
    sfContext::getInstance()->getLogger()->info(sprintf("{comment} %s", $comment_object->getText()));
    if (!$this->getUser()->isAuthenticated() && strpos($comment_object->getText(), 'href') !== false)
    {
      $commented_object->unpublishComment($comment_object->getId());
      $this->getRequest()->setAttribute('comment', $comment_object);
      $raw_email = $this->sendEmail('deppCommenting', 'notifyModeratorsOnCommentWithLink');  
      $this->logMessage($raw_email, 'debug');
      $this->setFlash('warning', 'Il commento proviene da un utente non autenticato e contiene un link ipertestuale. Sar&agrave; pubblicato solo dopo un controllo da parte della redazione, per evitare fastidiose forme di spam. Grazie per la pazienza.'); 
      
    }
  
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
 
  public function executeNotifyModeratorsOnCommentWithLink()
  {
    $this->comment_object = $this->getRequest()->getAttribute('comment');    
    $env = sfConfig::get('sf_environment', 'prod');
    $backend_controller = $env=='prod'?'be.php':"be_$env.php";
    $this->comments_backend_url = 'http://' . sfConfig::get('sf_site_url') . "/$backend_controller/deppCommentingAdmin";

    // do not send email if no news
    if (!$this->comment_object instanceof sfComment) return sfView::NONE;
    
    // mail class initialization
    $mail = new sfMail();
    $mail->setCharset('utf-8');      
    $mail->setContentType('text/html');

    // definition of the required parameters
    $mail->setSender(sfConfig::get('app_notifications_sender_address', 'noreply@openpolis.it'), 
                     sfConfig::get('app_notifications_from_tag', 'openparlamento'));
    $mail->setFrom(sfConfig::get('app_notifications_from_address', 'noreply@openpolis.it'), 
                   sfConfig::get('app_notifications_from_tag', 'openparlamento'));
                   
    $moderators = array('vittorio@openpolis.it', 'ettore@openpolis.it', 'guglielmo@openpolis.it', 'vincenzo@openpolis.it');
    foreach ($moderators as $moderator) {
      $mail->addAddress($moderator);
    }

    // invia tutte le mail in BCC a un indirizzo di servizio
    $mail->addBcc('servizi@depp.it');

    $mail->setSubject("[openparlamento] nuovo commento contenente link");

    $this->mail = $mail;
  }
 
 
}
