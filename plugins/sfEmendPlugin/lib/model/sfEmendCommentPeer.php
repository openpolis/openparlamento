<?php

/**
 * Subclass for performing query and update operations on the 'sf_emend_comment' table.
 *
 * 
 *
 * @package plugins.sfEmendPlugin.lib.model
 */ 
class sfEmendCommentPeer extends BasesfEmendCommentPeer
{
  
  public static function getAllCommentsForResource($resource, $con = null)
  {
    $c = new Criteria();
    $c->add(sfEmendCommentPeer::URL, $resource);
    $c->add(sfEmendCommentPeer::IS_PUBLIC, 1);
    return sfEmendCommentPeer::doSelect($c, $con);
  }

  public static function addComment($resource, $comment)
  {
    $c = new sfEmendComment();

    // set url
    $c->setUrl($resource);
    
    // set title, body and selection
    $c->setTitle(strip_tags($comment['title']));
    $c->setBody(sfEmendToolkit::clean($comment['body']));
    $c->setSelection(strip_tags($comment['selection']));

    // set author_name
    $curr_user = sfContext::getInstance()->getUser();
    $user_options = sfConfig::get('app_sfEmendPlugin_user', array());
    
    if ($curr_user->isAuthenticated())
    {
      if (is_callable(get_class($curr_user), $user_options['cu_id_method']))
      {
        $c->setAuthorId(call_user_func(array($curr_user, $user_options['cu_id_method'])));
      }
      
      if (is_callable(array($user_options['profile_class'].'Peer', 'retrieveByPK')))
      {

        $user = call_user_func($user_options['profile_class'].'Peer::retrieveByPk', 
                                     $c->getAuthorId());

        if (array_key_exists('name_method', $user_options) && 
            is_callable(get_class($user), $user_options['name_method']))
        {
          $c->setAuthorName(call_user_func(array($user, $user_options['name_method'])));
        }
        
      }
    } else if ($user_options['allow_anonymous'] && !is_null($comment['author_name'])){
      $c->setAuthorName(strip_tags($comment['author_name']));
    } else {
      print_r($user_options);
      if (!$user_options['allow_anonymous'])
        throw new Exception("Anonymous posting not allowed by configuration.");
      if (is_null($comment['author_name']))
        throw new Exception("Anonymous posting requires an author_name parameter");      
    }

    
    // store permanently in the db
    $c->save();
    
    // return the comment object
    return $c;
    
  }
}
