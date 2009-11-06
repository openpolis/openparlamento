<?php

/*
 * This file is part of the sfSimpleBlog package.
 * (c) 2004-2006 Francois Zaninotto <francois.zaninotto@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once(SF_ROOT_DIR.'/plugins/sfSimpleBlogPlugin/modules/sfSimpleBlog/lib/BasesfSimpleBlogActions.class.php');

/**
 * Blog frontend
 *
 * @package    sfSimpleBlog
 * @subpackage plugin
 * @author     Francois Zaninotto <francois.zaninotto@symfony-project.com>
 * @version    SVN: $Id$
 */
class sfSimpleBlogActions extends BasesfSimpleBlogActions
{
  
  public function preExecute()
  {
    if(sfConfig::get('app_sfSimpleBlog_use_bundled_layout', true))
    {
      $this->setLayout(sfLoader::getTemplateDir('sfSimpleBlog', 'layout.php').'/layout');
      $this->getResponse()->addStylesheet('/sfSimpleBlogPlugin/css/blog.css');
    }

    deppFiltersAndSortVariablesManager::resetVars($this->getUser(), 'module', 'module', 
                                                  array('acts_filter', 'sf_admin/opp_atto/sort',
                                                        'votes_filter', 'sf_admin/opp_votazione/sort',
                                                        'pol_camera_filter', 'pol_senato_filter', 'sf_admin/opp_carica/sort',
                                                        'argomento/atti_filter', 'argomento_leggi/sort', 'argomento_nonleg/sort'));

    
  }
  
  
  public function executeShow()
  {
    // retrieve the user, by fetching from the class defined in app.yml (or in the sfGuardUser class)
    $user_class = sfConfig::get('app_sfSimpleBlog_user_class', 'sfGuardUser');
    $this->user = call_user_func(array($user_class."Peer", "retrieveByPK"), 
                                 $this->getUser()->getId());
    
    $this->post = sfSimpleBlogPostPeer::retrieveByStrippedTitleAndDate($this->getRequestParameter('stripped_title'), $this->getDateFromRequest());
    $this->forward404Unless($this->post);
    $this->comments = $this->post->getComments();
    if (sfConfig::get('app_sfSimpleBlog_comment_automoderation', 'first_post') === 'captcha')
    {
      $g = new Captcha();
      $this->getUser()->setAttribute('captcha', $g->generate());      
    }
    
  }
  
  
  public function validateAddComment()
  {
    $captcha = $this->getRequestParameter('captcha');
    if (!sfContext::getInstance()->getUser()->isAuthenticated() && sfConfig::get("app_sfSimpleBlog_comment_automoderation"))
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
    $this->forward404Unless(sfConfig::get('app_sfSimpleBlog_comment_enabled', true));
    $post = sfSimpleBlogPostPeer::retrieveByStrippedTitleAndDate($this->getRequestParameter('stripped_title'), $this->getRequestParameter('date'));
    $this->forward404Unless($post);
    $this->forward404Unless($post->allowComments());

    $comment = new sfSimpleBlogComment();
    $comment->setSfBlogPostId($post->getId());
    $automoderation = sfConfig::get('app_sfSimpleBlog_comment_automoderation', 'first_post');
    if($automoderation === true || 
       (($automoderation === 'first_post') &&
        !sfSimpleBlogCommentPeer::isAuthorApproved($this->getRequestParameter('name'),$this->getRequestParameter('mail'))))
    {
      $comment->setIsModerated(true);
      $this->setFlash('add_comment', 'moderated');
    }
    else
    {
      $this->setFlash('add_comment', 'normal'); 
    }
    $comment->setAuthorName($this->getRequestParameter('name'));
    $comment->setAuthorEmail($this->getRequestParameter('mail'));
    if($url = $this->getRequestParameter('website', ''))
    {
      if(strpos($url, 'http://') !== 0)
      {
        $url = 'http://'.$url; 
      }
      $comment->setAuthorUrl($url);
    }
    $comment->setContent(strip_tags($this->getRequestParameter('content')));
    $comment->save();
    
    $email_pref = sfConfig::get('app_sfSimpleBlog_comment_mail_alert', 1);
    if($email_pref == 1 || ($email_pref == 'moderated' && $comment->getIsModerated()))
    {
      $this->getRequest()->setAttribute('comment', $comment);
      $raw_email = $this->sendEmail('sfSimpleBlog', 'sendMailOnComment');  
      $this->logMessage($raw_email, 'debug');
    }
    
    if($this->getRequest()->isXmlHttpRequest())
    {
      $this->post = $post;
      $this->comments = $post->getComments();
      return 'Ajax';
    }
    else
    {
      $this->redirect(sfSimpleBlogTools::generatePostUri($post));
    }
  }

  public function executeSendMailOnComment()
  {
    // Mail action cannot be called directly from the outside
    $this->forward404If($this->getController()->getActionStack()->getSize() == 1);
    
    sfLoader::loadHelpers(array('I18N'));
    $this->comment = $this->getRequest()->getAttribute('comment');

    $mail = new sfMail();
    $mail->setCharset('utf-8');      
    $mail->setSender('no-reply@'.$this->getRequest()->getHost());
    $mail->setMailer('mail');
    $mail->setFrom($mail->getSender(), sfConfig::get('app_sfSimpleBlog_title'));

    $mail->addAddresses(sfConfig::get('app_sfSimpleBlog_email'));

    $subject_string = '[%1%] New comment on post "%2%"';      
    $mail->setSubject(__($subject_string, array(
        '%1%' => sfConfig::get('app_sfSimpleBlog_title'),
        '%2%' => $this->comment->getPostTitle()
    )));
    
    $this->mail = $mail;  
  }
  
  public function executePostsFeed()
  {
    sfLoader::loadHelpers(array('I18N', 'Tag', 'Url'));

    $posts = sfSimpleBlogPostPeer::getRecent($this->getRequestParameter('nb', sfConfig::get('app_sfSimpleBlog_feed_count', 5)));
      
    
    $feed = new sfRss2ExtendedFeed();
    $feed->initialize(array(
      'title'       => __('Posts from %1%', array('%1%' => sfConfig::get('app_sfSimpleBlog_title', ''))),
      'link'        => $this->getController()->genUrl('sfSimpleBlog/index'),
      'siteUrl'     => 'http://' . sfConfig::get('sf_site_url'),
      'image'       => 'http://' . sfConfig::get('sf_site_url') . '/images/logo-openparlamento.png',
	    'feedUrl'     => $this->getRequest()->getURI(),
	    'language'    => 'it',
	    'copyright'   => "Licenza Creative Commons 'Attribuzione-Non commerciale-Non opere derivate 2.5 Generico'",
      'authorEmail' => 'info@openparlamento.it',
      'authorName'  => 'Openparlamento',
	    'description' => "Openparlamento.it - il progetto Openpolis per la trasparenza del Parlamento",
	    'ttl'         => 1440,	    
      'sy_updatePeriod' => 'daily',
      'sy_updateFrequency' => '4',
      'sy_updateBase' => '2000-01-01T12:00+00:00'	    
    ));

    foreach ($posts as $post)
    {
      $item = new sfRss2ExtendedItem();
      $item->initialize( array(
        'title'       => $post->getTitle(),
        'link' => sfSimpleBlogTools::generatePostUri($post, null),
        'authorEmail' => 'info@openparlamento.it',
        'authorName'  => 'Openparlamento',
        'pubDate' => $post->getPublishedAt('U'),
        'permalink' => url_for('@blog_article?stripped_title=' . $post->getStrippedTitle(), true),
        'description' => $post->getContent(),
      ));
      $feed->addItem($item);
    }

    $this->setLayout(false);    
    $this->response->setContentType('text/xml');
    $this->response->setContent($feed->asXml());

    return sfView::NONE;
  }

  public function executeCommentsFeed()
  {
    sfLoader::loadHelpers(array('I18N', 'Tag', 'Url'));
    $comments = sfSimpleBlogCommentPeer::getRecent($this->getRequestParameter('nb', sfConfig::get('app_sfSimpleBlog_feed_count', 5)));

    $feed = new sfRss2ExtendedFeed();
    $feed->initialize(array(
      'title'       => __('Comments from %1%', array('%1%' => sfConfig::get('app_sfSimpleBlog_title', ''))),
      'link'        => $this->getController()->genUrl('sfSimpleBlog/index'),
      'siteUrl'     => 'http://' . sfConfig::get('sf_site_url'),
      'image'       => 'http://' . sfConfig::get('sf_site_url') . '/images/logo-openparlamento.png',
	    'feedUrl'     => $this->getRequest()->getURI(),
	    'language'    => 'it',
	    'copyright'   => "Licenza Creative Commons 'Attribuzione-Non commerciale-Non opere derivate 2.5 Generico'",
      'authorEmail' => 'info@openparlamento.it',
      'authorName'  => 'Openparlamento',
	    'description' => "Openparlamento.it - il progetto Openpolis per la trasparenza del Parlamento",
	    'ttl'         => 1440,	    
      'sy_updatePeriod' => 'daily',
      'sy_updateFrequency' => '4',
      'sy_updateBase' => '2000-01-01T12:00+00:00'	    
    ));

    foreach ($comments as $comment)
    {
      $post = $comment->getsfSimpleBlogPost();
      $item = new sfRss2ExtendedItem();
      $item->initialize( array(
        'title'       => "Commento sul post: " . $post->getTitle(),
        'link' => sfSimpleBlogTools::generatePostUri($post, null),
        'authorEmail' => 'info@openparlamento.it',
        'authorName'  => 'Openparlamento',
        'pubDate' => $comment->getCreatedAt('U'),
        'permalink' => url_for('@blog_article?stripped_title=' . $post->getStrippedTitle(), true) . "#" . $comment->getId(),
        'description' => $comment->getContent(),
      ));
      $feed->addItem($item);
    }

    $this->setLayout(false);    
    $this->response->setContentType('text/xml');
    $this->response->setContent($feed->asXml());

    return sfView::NONE;

  }

  public function executeCommentsForPostFeed()
  {
    sfLoader::loadHelpers(array('I18N'));
    $post = sfSimpleBlogPostPeer::retrieveByStrippedTitleAndDate($this->getRequestParameter('stripped_title'), $this->getDateFromRequest());
    $this->forward404Unless($post);
    $comments = sfSimpleBlogCommentPeer::getForPost($post, $this->getRequestParameter('nb', sfConfig::get('app_sfSimpleBlog_feed_count', 5)));
    
    $this->feed = sfFeedPeer::createFromObjects(
      $comments,
      array(
        'format'      => $this->getRequestParameter('format', 'atom1'),
        'title'       => __('Comments on post "%1%" from %2%', array('%1%' => $post->getTitle(), '%2%' => sfConfig::get('app_sfSimpleBlog_title', ''))),
        'link'        => $this->getController()->genUrl('sfSimpleBlog/show?stripped_title='.$post->getStrippedTitle()),
        'authorName'  => sfConfig::get('app_sfSimpleBlog_author', ''),
        'methods'     => array('title' => 'getPostTitle', 'authorEmail' => '')
      )
    );
    $this->setTemplate('feed');
  }
  
  
}
