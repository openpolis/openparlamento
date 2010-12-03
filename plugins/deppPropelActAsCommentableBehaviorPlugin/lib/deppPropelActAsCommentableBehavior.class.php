<?php
/**
 * This file is part of the deppPropelActAsCommentableBehavior package.
 * 
 * (c) 2008 Guglielmo Celata <guglielmo@depp.it>
 * based on sfPropelActAsCommentable, by Xavier Lacot <xavier@lacot.org>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * This behavior permits to attach comments to Propel objects. Some more bits
 * about the philosophy of the stuff:
 *
 * - commentable objects must have a primary key
 * - comments can only be attached on objects that have already been saved
 * - comments are saved when applied
 *
 * @author   Guglielmo Celata <guglielmo@depp.it>
 * @author   Xavier Lacot <xavier@lacot.org>
 * @see      http://www.symfony-project.com/trac/wiki/sfPropelActAsCommentableBehaviorPlugin
 */

class deppPropelActAsCommentableBehavior
{
  /**
   * Adds a comment to the object. 
   * The "comment" param can be a string, an associative array 
   * (in which each element represents one of the comment properties), or
   * an array of associative arrays. In this case, it adds all the comments to
   * the object.
   *
   * @param      BaseObject  $object
   * @param      array       $comment
   */
  public function addComment(BaseObject $object, $comment)
  {
    if ($object->isNew() === true)
    {
      throw new Exception('Comments can only be attached to already saved objects');
    }

    if (is_array($comment))
    {
      // array of associative arrays
      if (!isset($comment['text']))
      {
        foreach ($comment as $onecomment)
        {
          $this->addComment($object, $onecomment);
        }
      }
      else
      {


        // associative array (with the text key not void)
        if (strlen($comment['text']) > 0)
        {

          if (isset($comment['title']))
          {
            $comment['title'] = strip_tags($comment['title']);
          }

          if (isset($comment['author_name']))
          {
            $comment['author_name']  = strip_tags($comment['author_name']);
          }

          if (isset($comment['author_email']))
          {
            $comment['author_email']  = strip_tags($comment['author_email']);
          }

          if (isset($comment['author_website']))
          {
            $comment['author_website']  = strip_tags($comment['author_website']);
          }

          // store comment's text, after cleaning it (see app.yml)
          $comment['text'] = deppPropelActAsCommentableToolkit::clean($comment['text']);

          $comment['created_at'] = time();

          if (!isset($comment['namespace']))
          {
            $comment['namespace'] = null;
          }

          $comment_object = new sfComment();
          $comment_object->fromArray($comment, BasePeer::TYPE_FIELDNAME);
          $comment_object->setCommentableId($object->getPrimaryKey());
          $comment_object->setCommentableModel(get_class($object));

          // when the current user is authenticated, a connection to the user table is made
          $user_options = sfConfig::get('app_deppPropelActAsCommentableBehaviorPlugin_user', array());
          $curr_user = sfContext::getInstance()->getUser();


          if ($user_options['enabled'] && $curr_user->isAuthenticated())
          {
            if (is_callable(get_class($curr_user), $user_options['cu_id_method']))
            {
              $comment_object->setAuthorId(call_user_func(array($curr_user, $user_options['cu_id_method'])));
            }
            
            if (is_callable(array($user_options['class'].'Peer', 'retrieveByPK')))
            {

              $user = call_user_func($user_options['class'].'Peer::retrieveByPk', 
                                           $comment_object->getAuthorId());

              if (array_key_exists('name_method', $user_options) && 
                  is_callable(get_class($user), $user_options['name_method']))
              {
                $comment_object->setAuthorName(call_user_func(array($user, $user_options['name_method'])));
              }
              
              if (array_key_exists('email_method', $user_options) && 
                  is_callable(get_class($user), $user_options['email_method']))
              {
                $comment_object->setAuthorEmail(call_user_func(array($user, $user_options['email_method'])));
              }
              
              if (array_key_exists('website_method', $user_options) && 
                  is_callable(get_class($user), $user_options['website_method']))
              {
                $comment_object->setAuthorWebsite(call_user_func(array($user, $user_options['website_method'])));
              }
              
            }
          }
          
          $comment_object->save();
          self::_checkAndSaveCountCache($object, $comment['namespace']);

          return $comment_object;
        }
      }
    }
    elseif (is_string($comment))
    {
      $this->addComment($object, array('text' => $comment));
    }
    else
    {
      new Exception('A comment must be represented as string, an associative array with a "text" key, or an array of associative arrays');
    }
  }

  /**
   * Returns the list of the comments attached to the object. The options array
   * can contain the options :
   * - order : order of the comments (always by date, 'asc' or 'desc')
   *
   * @param      BaseObject  $object
   * @param      Array       $options
   * @param      Criteria    $criteria
   *
   * @return     Array
   */
  public function getComments(BaseObject $object, $options = array(), Criteria $criteria = null)
  {
    $c = $this->getCommentsCriteria($object, $options, $criteria);
    $comment_objects = sfCommentPeer::doSelect($c);
    $comments = array();

    foreach ($comment_objects as $comment_object)
    {
      $comment = $comment_object->toArray();
      $comments[] = $comment;
    }

    return $comments;
  }

  /**
   * Returns the list of public comments attached to the object. The options array
   * can contain the options :
   * - order : order of the comments (always by date, 'asc' or 'desc')
   *
   * @param      BaseObject  $object
   * @param      Array       $options
   * @param      Criteria    $criteria
   *
   * @return     Array
   */
  public function getPublicComments(BaseObject $object, $options = array(), Criteria $criteria = null)
  {
    $c = $this->getCommentsCriteria($object, $options, $criteria);
    $c->add(sfCommentPeer::IS_PUBLIC, 1);

    return $this->getComments($object, $options, $c);
  }
  
  
  /**
   * Returns a criteria for comments selection. The options array
   * can contain the options :
   * - order : order of the comments (always by date, 'asc' or 'desc')
   *
   * @param      BaseObject  $object
   * @param      Array       $options
   * @param      Criteria    $criteria
   *
   * @return     Array
   */
  protected function getCommentsCriteria(BaseObject $object, $options = array(), Criteria $criteria = null)
  {
    if ($criteria != null)
    {
      $c = clone $criteria;
    }
    else
    {
      $c = new Criteria();
    }

    $c->add(sfCommentPeer::COMMENTABLE_ID, $object->getPrimaryKey());
    $c->add(sfCommentPeer::COMMENTABLE_MODEL, get_class($object));

    if (isset($options['namespace']))
    {
      $c->add(sfCommentPeer::COMMENT_NAMESPACE, $options['namespace']);
    }

    if (isset($options['order']) && ($options['order'] == 'desc'))
    {
      $c->addDescendingOrderByColumn(sfCommentPeer::CREATED_AT);
      $c->addDescendingOrderByColumn(sfCommentPeer::ID);
    }
    else
    {
      $c->addAscendingOrderByColumn(sfCommentPeer::CREATED_AT);
      $c->addAscendingOrderByColumn(sfCommentPeer::ID);
    }

    return $c;
  }

  /**
   * Returns the number of the comments attached to the object.
   * These options can be specified
   * - order : order of the comments (always by date, 'asc' or 'desc')
   *
   * @param      BaseObject  $object
   * @param      Array       $options
   * @param      Criteria    $criteria
   *
   * @return     integer
   */
  public function getNbComments(BaseObject $object, $options = array(), Criteria $criteria = null)
  {
    $c = $this->getCommentsCriteria($object, $options, $criteria);
    return sfCommentPeer::doCount($c);
  }

  /**
   * Returns the number of public comments attached to the object.
   *
   * @param      BaseObject  $object
   * @param      Criteria    $criteria
   *
   * @return     integer
   */
  public function getNbPublicComments(BaseObject $object, Criteria $criteria = null)
  {
    $c = $this->getCommentsCriteria($object, array(), $criteria);
    $c->add(sfCommentPeer::IS_PUBLIC, 1);

    return sfCommentPeer::doCount($c);
  }


  /**
   * Deletes all the comments attached to the object
   *
   * @param      BaseObject  $object
   * @param      string      $namespace
   * @return     boolean
   */
  public function clearComments(BaseObject $object, $namespace = null)
  {
    $c = new Criteria();
    $c->add(sfCommentPeer::COMMENTABLE_ID, $object->getPrimaryKey());
    $c->add(sfCommentPeer::COMMENTABLE_MODEL, get_class($object));

    if ($namespace != null)
    {
      $c->add(sfCommentPeer::COMMENT_NAMESPACE, $namespace);
    }

    $res = sfCommentPeer::doDelete($c);

    self::_checkAndSaveCountCache($object, $namespace);

    return $res;
  }


  /**
   * Removes one comment from the object. All namespaces.
   *
   * @param      BaseObject  $object
   */
  public function removeComment(BaseObject $object, $comment_id)
  {
    $c = new Criteria();
    $c->add(sfCommentPeer::COMMENTABLE_ID, $object->getPrimaryKey());
    $c->add(sfCommentPeer::COMMENTABLE_MODEL, get_class($object));
    $c->add(sfCommentPeer::ID, $comment_id);
    $res = sfCommentPeer::doDelete($c);

    self::_checkAndSaveCountCache($object);

    return $res;
  }
  
  public function publishComment(BaseObject $object, $comment_id)
  {
    $comment = sfCommentPeer::retrieveByPK($comment_id);
    $comment->setIsPublic(1);
    $comment->save(); 
    self::_checkAndSaveCountCache($object);
  }

  public function unpublishComment(BaseObject $object, $comment_id)
  {
    $comment = sfCommentPeer::retrieveByPK($comment_id);
    $comment->setIsPublic(0);
    $comment->save();    
    self::_checkAndSaveCountCache($object);
  }
  
  
  public static function _checkAndSaveCountCache(BaseObject $object, $namespace = null)
  {

    // read count cache options from propel behavior definition (in the object's class override, in lib)
    $count_cache_enabled = sfConfig::get(sprintf('propel_behavior_deppPropelActAsCommentableBehavior_%s_count_cache_enabled', get_class($object)), false);
    $count_cache_public = sfConfig::get(sprintf('propel_behavior_deppPropelActAsCommentableBehavior_%s_count_cache_public', get_class($object)), true);
    $count_cache_method = sfConfig::get(sprintf('propel_behavior_deppPropelActAsCommentableBehavior_%s_count_cache_method', get_class($object)));
    $count_cache_namespace = sfConfig::get(sprintf('propel_behavior_deppPropelActAsCommentableBehavior_%s_count_cache_namespace', get_class($object)), false);

    if ($count_cache_enabled
        && is_callable(array($object, $count_cache_method)))
    {
      if ($count_cache_namespace !== false && isset($namespace) && $namespace === $count_cache_namespace)
      {
        $options = array('namespace' => $count_cache_namespace);
        call_user_func(array($object, $count_cache_method),
                       $count_cache_public?$object->getNbPublicComments($options):$object->getNbComments($options));
      }
      elseif (false === $count_cache_namespace)
      {
        call_user_func(array($object, $count_cache_method),
                       $count_cache_public?$object->getNbPublicComments():$object->getNbComments());
      }

      $object->save();
    }
    
  }
  
    
  /**
   * Deletes all comments for a commentable object (on delete cascade emulation)
   * 
   * @param  BaseObject  $object
   */
  public function preDelete(BaseObject $object)
  {
    try
    {
      $c = new Criteria();
      $c->add(sfCommentPeer::COMMENTABLE_ID, $object->getPrimaryKey());
      sfCommentPeer::doDelete($c);
    }
    catch (Exception $e)
    {
      throw new Exception(
        'Unable to delete comments related to commentable object');
    }
  }
  
}