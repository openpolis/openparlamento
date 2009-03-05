<?php
/**
 * deppPropelActAsCommentableBehaviorPlugin base componente
 * 
 * @package    plugins
 * @subpackage deppPropelActAsCommentableBehaviorPlugin/deppCommenting
 */
class BasedeppCommentingComponents extends sfComponents
{
  public function executeAddComment()
  {
    // retrieve contentPeer class from content
    $this->content_peer = get_class($this->content) . "Peer";
    
    // embed stylesheets
	  $response = sfContext::getInstance()->getResponse();
    $response->addStylesheet('/deppPropelActAsCommentableBehaviorPlugin/css/depp_commenting.css');

    
    if (!sfContext::getInstance()->getUser()->isAuthenticated() &&
        $this->automoderation == 'captcha')
    {
      $g = new Captcha();
      $this->getUser()->setAttribute('captcha', $g->generate());      
    }

    // when the current user is authenticated, a connection to the user table is made
    // then informations about the user (name, email and website) are gathered from the user table
    // being parametric, this is somewhat complicated, 
    // and is based on the app_deppPropelActAsCommentableBehaviorPlugin plugin
    $user_options = sfConfig::get('app_deppPropelActAsCommentableBehaviorPlugin_user', array());
    $curr_user = $this->getUser();
    if ($user_options['enabled'] && $curr_user->isAuthenticated())
    {
      if (is_callable(array($curr_user, $user_options['cu_id_method'])))
      {
        $author_id = call_user_func(array($curr_user, $user_options['cu_id_method']));
      }
      
      if (is_callable(array($user_options['class'].'Peer', 'retrieveByPK')))
      {

        $user = call_user_func($user_options['class'].'Peer::retrieveByPk', 
                               $author_id);

        if (array_key_exists('name_method', $user_options) && 
            is_callable(get_class($user), $user_options['name_method']))
        {
          $this->author_name = call_user_func(array($user, $user_options['name_method']));
        }
        
        if (array_key_exists('email_method', $user_options) && 
            is_callable(get_class($user), $user_options['email_method']))
        {
          $this->author_email = call_user_func(array($user, $user_options['email_method']));
        }
        
        if (array_key_exists('website_method', $user_options) && 
            is_callable(get_class($user), $user_options['website_method']))
        {
          $this->author_website = call_user_func(array($user, $user_options['website_method']));
        }
        
      }
    }

    // set session variable for comments (namespace comment)
    $this->getUser()->setAttribute('content_id', $this->content->getId(), 'comment');
    $this->getUser()->setAttribute('content_peer', $this->content_peer, 'comment');
    if (isset($this->original_url))
      $this->getUser()->setAttribute('original_url', $this->original_url, 'comment');
    else
      $this->getUser()->setAttribute('original_url', $this->getRequest()->getURI(), 'comment');
    $this->getUser()->setAttribute('read_only', $this->read_only, 'comment');
    $this->getUser()->setAttribute('automoderation', $this->automoderation, 'comment');
    
  }

  
}