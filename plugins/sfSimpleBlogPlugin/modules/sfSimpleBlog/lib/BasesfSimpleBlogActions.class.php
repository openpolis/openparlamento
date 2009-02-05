<?php

/*
 * This file is part of the sfSimpleBlog package.
 * (c) 2004-2006 Francois Zaninotto <francois.zaninotto@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Blog frontend actions
 *
 * @package    sfSimpleBlog
 * @subpackage plugin
 * @author     Francois Zaninotto <francois.zaninotto@symfony-project.com>
 * @version    SVN: $Id$
 */
class BasesfSimpleBlogActions extends sfActions
{
  public function preExecute()
  {
    if(sfConfig::get('app_sfSimpleBlog_use_bundled_layout', true))
    {
      $this->setLayout(sfLoader::getTemplateDir('sfSimpleBlog', 'layout.php').'/layout');
      $this->getResponse()->addStylesheet('/sfSimpleBlogPlugin/css/blog.css');
    }
  }

  public function executeIndex()
  {
    $this->post_pager = sfSimpleBlogPostPeer::getRecentPager(
      sfConfig::get('app_sfSimpleBlog_post_max_per_page', 5),
      $this->getRequestParameter('page', 1)
    );
  }

  public function executePostsFeed()
  {
    sfLoader::loadHelpers(array('I18N'));
    $posts = sfSimpleBlogPostPeer::getRecent($this->getRequestParameter('nb', sfConfig::get('app_sfSimpleBlog_feed_count', 5)));
      
    $this->feed = sfFeedPeer::createFromObjects(
      $posts,
      array(
        'format'      => $this->getRequestParameter('format', 'atom1'),
        'title'       => __('Posts from %1%', array('%1%' => sfConfig::get('app_sfSimpleBlog_title', ''))),
        'link'        => $this->getController()->genUrl('sfSimpleBlog/index'),
        'authorName'  => sfConfig::get('app_sfSimpleBlog_author', ''),
        'methods'     => array('authorEmail' => '', 'authorName'  => 'getAuthor')
      )
    );
    $this->setTemplate('feed');
  }

  public function executeCommentsFeed()
  {
    sfLoader::loadHelpers(array('I18N'));
    $comments = sfSimpleBlogCommentPeer::getRecent($this->getRequestParameter('nb', sfConfig::get('app_sfSimpleBlog_feed_count', 5)));
      
    $this->feed = sfFeedPeer::createFromObjects(
      $comments,
      array(
        'format'      => $this->getRequestParameter('format', 'atom1'),
        'title'       => __('Comments from %1%', array('%1%' => sfConfig::get('app_sfSimpleBlog_title', ''))),
        'link'        => $this->getController()->genUrl('sfSimpleBlog/index'),
        'authorName'  => sfConfig::get('app_sfSimpleBlog_author', ''),
        'methods'     => array('title' => 'getPostTitle', 'authorEmail' => '')
      )
    );
    $this->setTemplate('feed');
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

  public function executeShowByTag()
  {
    $tag = $this->getRequestParameter('tag');
    $this->forward404Unless($tag);
    $this->post_pager = sfSimpleBlogPostPeer::getTaggedPager(
      $tag,
      sfConfig::get('app_sfSimpleBlog_post_max_per_page', 5),
      $this->getRequestParameter('page', 1)
    ); 
  }
  
  public function executePostsForTagFeed()
  {
    sfLoader::loadHelpers(array('I18N'));
    $tag = $this->getRequestParameter('tag');
    $this->forward404Unless($tag);
    $posts = sfSimpleBlogPostPeer::getTagged($tag, $this->getRequestParameter('nb', sfConfig::get('app_sfSimpleBlog_feed_count', 5)));
    
    $this->feed = sfFeedPeer::createFromObjects(
      $posts,
      array(
        'format'      => $this->getRequestParameter('format', 'atom1'),
        'title'       => __('Posts tagged "%1%" from %2%', array('%1%' => $tag, '%2%' => sfConfig::get('app_sfSimpleBlog_title', ''))),
        'link'        => $this->getController()->genUrl('sfSimpleBlog/showByTag?tag='.$tag),
        'authorName'  => sfConfig::get('app_sfSimpleBlog_author', ''),
        'methods'     => array('authorEmail' => '')
      )
    );
    $this->setTemplate('feed');
  }
     
  public function executeShow()
  {
    $this->post = sfSimpleBlogPostPeer::retrieveByStrippedTitleAndDate($this->getRequestParameter('stripped_title'), $this->getDateFromRequest());
    $this->forward404Unless($this->post);
    $this->comments = $this->post->getComments();
  }

  protected function getDateFromRequest()
  {
    return $this->getRequestParameter('year').'-'.$this->getRequestParameter('month').'-'.$this->getRequestParameter('day');
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
    if($automoderation === true || (($automoderation == 'first_post') && !sfSimpleBlogCommentPeer::isAuthorApproved($this->getRequestParameter('name'),$this->getRequestParameter('mail'))))
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

    if($this->comment->getIsModerated())
    {
      $subject_string = '[%1%] Please moderate: New comment on "%2%"';
    }
    else
    {
      $subject_string = '[%1%] New comment on "%2%"';      
    }
    $mail->setSubject(__($subject_string, array(
        '%1%' => sfConfig::get('app_sfSimpleBlog_title'),
        '%2%' => $this->comment->getPostTitle()
    )));
    
    $this->mail = $mail;  
  }
  
  public function handleErrorAddComment()
  {
    if($this->getRequest()->isXmlHttpRequest())
    {
      $this->post = sfSimpleBlogPostPeer::retrieveByStrippedTitleAndDate($this->getRequestParameter('stripped_title'), $this->getRequestParameter('date'));
      $this->forward404Unless($this->post);
      $this->comments = $this->post->getComments();
      $this->getResponse()->setContentType('text/html; charset=utf-8');
      return 'Ajax'; 
    }
    else
    {
      $this->forward('sfSimpleBlog', 'show'); 
    }
  }

}
