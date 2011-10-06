<?php
/*
 * This file is part of the deppPropelActAsTaggableBehavior package.
 *
 * (c) 2008 Guglielmo Celata <guglielmo.celata@gmail.com>
 * (c) 2007 Xavier Lacot <xavier@lacot.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/*
 * This behavior permits to attach tags to Propel objects. Some more bits about
 * the philosophy of the stuff:
 *
 * - taggable objects must have a primary key
 *
 * - tags are saved when the object is saved, not before
 *
 * - one object cannot be tagged twice with the same tag. When trying to use
 *   twice the same tag on one object, the second tagging will be ignored
 *
 * - the tags associated to one taggable object are only loaded when necessary.
 *   Then they are cached.
 *
 * - once created, tags never change in the Tag table. When using replaceTag(),
 *   a new tag is created if necessary, but the old one is not deleted.
 *
 *
 * The plugin associates a parameterHolder to Propel objects, with 3 namespaces:
 *
 * - tags:
 *     Tags that have been attached to the object, but not yet saved.
 *     Contract: tags are disjoin of (saved_tags union removed_tags)
 *
 * - saved_tags:
 *     Tags that are presently saved in the database
 *
 * - removed_tags:
 *     Tags that are presently saved in the database, but which will be removed
 *     at the next save()
 *     Contract: removed_tags are disjoin of (tags union saved_tags)
 *
 *
 * @author   Xavier Lacot <xavier@lacot.org>
 * @see      http://www.symfony-project.com/trac/wiki/deppPropelActAsTaggableBehaviorPlugin
 */

class deppPropelActAsTaggableBehavior
{
  /**
   * parameterHolder access methods
   */
  private static function getTagsHolder(BaseObject $object)
  {
    if ((!isset($object->_tags)) || ($object->_tags == null))
    {
      if (class_exists('sfNamespacedParameterHolder'))
      {
        // Symfony 1.1
        $parameter_holder = 'sfNamespacedParameterHolder';
      }
      else
      {
        // Symfony 1.0
        $parameter_holder = 'sfParameterHolder';
      }

      $object->_tags = new $parameter_holder();
    }

    return $object->_tags;
  }

  private static function add_tag(BaseObject $object, $tag)
  {
    $tag = deppPropelActAsTaggableToolkit::cleanTagName($tag);

    if (strlen($tag) > 0)
    {
      self::getTagsHolder($object)->set($tag, $tag, 'tags');
    }
  }

  private static function clear_tags(BaseObject $object)
  {
    return self::getTagsHolder($object)->removeNamespace('tags');
  }

  private static function get_tags(BaseObject $object)
  {
    return self::getTagsHolder($object)->getAll('tags');
  }

  private static function set_tags(BaseObject $object, $tags)
  {
    self::clear_tags($object);
    self::getTagsHolder($object)->add($tags, 'tags');
  }

  private static function add_saved_tag(BaseObject $object, $tag)
  {
    self::getTagsHolder($object)->set($tag, $tag, 'saved_tags');
  }

  private static function clear_saved_tags(BaseObject $object)
  {
    return self::getTagsHolder($object)->removeNamespace('saved_tags');
  }

  private static function get_saved_tags(BaseObject $object)
  {
    return self::getTagsHolder($object)->getAll('saved_tags');
  }

  private static function set_saved_tags(BaseObject $object, $tags = array())
  {
    self::clear_saved_tags($object);
    self::getTagsHolder($object)->add($tags, 'saved_tags');
  }

  private static function add_removed_tag(BaseObject $object, $tag)
  {
    self::getTagsHolder($object)->set($tag, $tag, 'removed_tags');
  }

  private static function clear_removed_tags(BaseObject $object)
  {
    return self::getTagsHolder($object)->removeNamespace('removed_tags');
  }

  private static function get_removed_tags(BaseObject $object)
  {
    return self::getTagsHolder($object)->getAll('removed_tags');
  }

  private static function set_removed_tags(BaseObject $object, $tags)
  {
    self::clear_removed_tags($object);
    self::getTagsHolder($object)->add($tags, 'removed_tags');
  }


  /**
   * Adds a tag to the object. The "tagname" param can be a string or an array
   * of strings. These 3 code sequences produce an equivalent result :
   *
   * 1- $object->addTag('tag1,tag2,tag3');
   * 2- $object->addTag('tag1');
   *    $object->addTag('tag2');
   *    $object->addTag('tag3');
   * 3- $object->addTag(array('tag1','tag2','tag3'));
   *
   * @param      BaseObject  $object
   * @param      mixed       $tagname
   */
  public function addTag(BaseObject $object, $tagname)
  {
    $tagname = deppPropelActAsTaggableToolkit::explodeTagString($tagname);

    if (is_array($tagname))
    {
      foreach ($tagname as $tag)
      {
        $this->addTag($object, $tag);
      }
    }
    else
    {
      $removed_tags = self::get_removed_tags($object);

      if (isset($removed_tags[$tagname]))
      {
        unset($removed_tags[$tagname]);
        self::set_removed_tags($object, $removed_tags);
        self::add_saved_tag($object, $tagname);
      }
      else
      {
        $saved_tags = $this->getSavedTags($object);

        if (sfConfig::get('app_deppPropelActAsTaggableBehaviorPlugin_triple_distinct', false))
        {
          // the binome namespace:key must be unique
          $triple = deppPropelActAsTaggableToolkit::extractTriple($tagname);

          if (!is_null($triple[1]) && !is_null($triple[2]))
          {
            $pattern = '/^'.$triple[1].':'.$triple[2].'=(.*)$/';
            $tags = $object->getTags(array('triple' => true, 'return' => 'tag'));
            $removed = array();

            foreach ($tags as $tag)
            {
              if (preg_match($pattern, $tag))
              {
                $removed[] = $tag;
              }
            }

            $object->removeTag($removed);
          }
        }

        if (!isset($saved_tags[$tagname]))
        {
          self::add_tag($object, $tagname);
        }
      }
    }
  }


  /**
   * Retrieves from the database tags that have been atached to the object.
   * Once loaded, this saved tags list is cached and updated in memory.
   *
   * @param      BaseObject  $object
   * @param      boolean     $force_cache_override if the DB must be read, even when the cache exists
   */
    private function getSavedTags(BaseObject $object, $force_cache_override=false)
  {
    if (!isset($object->_tags) || !$object->_tags->hasNamespace('saved_tags') || $force_cache_override)
    {
      if (true === $object->isNew())
      {
        self::set_saved_tags($object, array());
        return array();
      }
      else
      {
        $c = new Criteria();
        $c->add(TaggingPeer::TAGGABLE_ID, $object->getPrimaryKey());
        $c->add(TaggingPeer::TAGGABLE_MODEL, get_class($object));
        $c->addJoin(TaggingPeer::TAG_ID, TagPeer::ID);
        $saved_tags = TagPeer::doSelect($c);
        $tags = array();

        foreach ($saved_tags as $tag)
        {
          $tags[$tag->getName()] = $tag->getName();
        }

        self::set_saved_tags($object, $tags);
        return $tags;
      }
    }
    else
    {
      return self::get_saved_tags($object);
    }
  }

  /**
   * return Tag objects related to the taggable object
   *
   * @param BaseObject $object 
   * @return void
   * @author Guglielmo Celata
   */
  public function getTagsAsObjects(BaseObject $object, $criteria = null)
  {
    if (is_null($criteria))
      $c = new Criteria();
    else
      $c = clone $criteria;
      
    $c->add(TaggingPeer::TAGGABLE_ID, $object->getPrimaryKey());
    $c->add(TaggingPeer::TAGGABLE_MODEL, get_class($object));
    $c->addJoin(TaggingPeer::TAG_ID, TagPeer::ID);
    return TagPeer::doSelect($c);    
  }

  /**
   * return Tagging objects related to the taggable object
   *
   * @param BaseObject $object 
   * @return array of tagging objects
   * @author Guglielmo Celata
   */
  public function getTagsAsTaggingObjects(BaseObject $object, $criteria = null, $con = null)
  {
		if ($con === null) {
			$con = Propel::getConnection(TaggingPeer::DATABASE_NAME);
		}

    if (is_null($criteria))
      $c = new Criteria();
    else
      $c = clone $criteria;
      
    $c->add(TaggingPeer::TAGGABLE_ID, $object->getPrimaryKey());
    $c->add(TaggingPeer::TAGGABLE_MODEL, get_class($object));
    return TaggingPeer::doSelect($c);    
  }
  
  /**
   * Retrieves from the database tags that have been attached to the object by a user
   * If the user_id parameter is not passed, then retrieve all tags attached by the users (user_id is not null)
   *
   * @param      BaseObject  $object
   * @param      integer     $user_id
   */
  private function getUserSavedTags(BaseObject $object, $user_id = null)
  {    
    $c = new Criteria();
    $c->add(TaggingPeer::TAGGABLE_ID, $object->getPrimaryKey());
    $c->add(TaggingPeer::TAGGABLE_MODEL, get_class($object));
    $c->addJoin(TaggingPeer::TAG_ID, TagPeer::ID);
    if (!is_null($user_id) && $user_id != '')
    {
      $c->add(TaggingPeer::USER_ID, $user_id);
    } else {
      $c->add(TaggingPeer::USER_ID, null, Criteria::ISNOTNULL);
    }
    $saved_tags = TagPeer::doSelect($c);
    $tags = array();

    foreach ($saved_tags as $tag)
    {
      $tags[$tag->getName()] = $tag->getName();
    }

    return $tags;
  }


  /**
   * Returns the list of the tags attached to the object, whatever they have
   * already been saved or not.
   *
   * @param      BaseObject  $object
   * @param      boolean     $force_cache_override if the DB must be read, even when the cache exists
   */
  public function getTags(BaseObject $object, $options = array(), $force_cache_override=false)
  {
    $tags = array_merge(self::get_tags($object), $this->getSavedTags($object, $force_cache_override));

    if (isset($options['is_triple']) && (true === $options['is_triple']))
    {
      $tags = array_map(array('deppPropelActAsTaggableToolkit', 'extractTriple'), $tags);
      $pattern = array('tag', 'namespace', 'key', 'value');


      foreach ($pattern as $key => $value)
      {
        if (isset($options[$value]))
        {
          $tags_array = array();

          foreach ($tags as $tag)
          {
            if ($tag[$key] == $options[$value])
            {
              $tags_array[] = $tag;
            }
          }

          $tags = $tags_array;
        }
      }


      $return = (isset($options['return']) && in_array($options['return'], $pattern)) ? $options['return'] : 'all';

      if ('all' != $return)
      {
        $keys = array_flip($pattern);
        $tags_array = array();

        foreach ($tags as $tag)
        {
          if (null != $tag[$keys[$return]])
          {
            $tags_array[] = $tag[$keys[$return]];
          }
        }

        $tags = array_unique($tags_array);
      }
    }

    if (!isset($return) || ('all' != $return))
    {
      ksort($tags);

      if (isset($options['serialized']) && (true === $options['serialized']))
      {
        $tags = implode(', ', $tags);
      }
    }


    return $tags;
  }


  /**
   * Returns the list of the tags attached to the object by a user
   *
   * @param      BaseObject  $object
   * @param      Array       $options
   * @param      integer     $user_id
   */
  public function getUserTags(BaseObject $object, $options = array(), $user_id = null)
  {
    $tags = $this->getUserSavedTags($object, $user_id);

    if (isset($options['is_triple']) && (true === $options['is_triple']))
    {
      $tags = array_map(array('deppPropelActAsTaggableToolkit', 'extractTriple'), $tags);
      $pattern = array('tag', 'namespace', 'key', 'value');

      foreach ($pattern as $key => $value)
      {
        if (isset($options[$value]))
        {
          $tags_array = array();

          foreach ($tags as $tag)
          {
            if ($tag[$key] == $options[$value])
            {
              $tags_array[] = $tag;
            }
          }

          $tags = $tags_array;
        }
      }

      $return = (isset($options['return']) && in_array($options['return'], $pattern)) ? $options['return'] : 'all';

      if ('all' != $return)
      {
        $keys = array_flip($pattern);
        $tags_array = array();

        foreach ($tags as $tag)
        {
          if (null != $tag[$keys[$return]])
          {
            $tags_array[] = $tag[$keys[$return]];
          }
        }

        $tags = array_unique($tags_array);
      }
    }

    if (!isset($return) || ('all' != $return))
    {
      ksort($tags);

      if (isset($options['serialized']) && (true === $options['serialized']))
      {
        $tags = implode(', ', $tags);
      }
    }

    return $tags;
  }

  /**
   * Returns true if the object has a tag. If a tag ar an array of tags is
   * passed in second parameter, checks if these tags are attached to the object
   *
   * These 3 calls are equivalent :
   * 1- $object->hasTag('tag1')
   *    && $object->hasTag('tag2')
   *    && $object->hasTag('tag3');
   * 2- $object->hasTag('tag1,tag2,tag3');
   * 3- $object->hasTag(array('tag1', 'tag2', 'tag3'));
   *
   * @param      BaseObject  $object
   * @param      mixed       $tag
   */
  public function hasTag(BaseObject $object, $tag = null)
  {
    $tag = deppPropelActAsTaggableToolkit::explodeTagString($tag);

    if (is_array($tag))
    {
      $result = true;

      foreach ($tag as $tagname)
      {
        $result = $result && $this->hasTag($object, $tagname);
      }

      return $result;
    }
    else
    {
      $tags = self::get_tags($object);

      if ($tag === null)
      {
        return (count($tags) > 0) || (count($this->getSavedTags($object)) > 0);
      }
      elseif (is_string($tag))
      {
        $tag = deppPropelActAsTaggableToolkit::cleanTagName($tag);

        if (isset($tags[$tag]))
        {
          return true;
        }
        else
        {
          $saved_tags = $this->getSavedTags($object);
          $removed_tags = self::get_removed_tags($object);
          return isset($saved_tags[$tag]) && !isset($removed_tags[$tag]);
        }
      }
      else
      {
        $msg = sprintf('hasTag() does not support this type of argument : %s.', get_class($tag));
        throw new Exception($msg);
      }
    }
  }

  /**
   * Tags saving logic, runned after the object himself has been saved
   *
   * @param      BaseObject  $object
   */
  public function postSave(BaseObject $object)
  {
    $tags = self::get_tags($object);
    $removed_tags = self::get_removed_tags($object);

    // read some config parameters and defaults
    $anonymous_tagging =  sfConfig::get(
      sprintf('propel_behavior_deppPropelActAsTaggableBehavior_%s_anonymous_tagging', 
              get_class($object)),
      sfConfig::get('app_deppPropelActAsTaggableBehaviorPlugin_anonymous_tagging', true));
    $allows_tagging_removal =  sfConfig::get(
      sprintf('propel_behavior_deppPropelActAsTaggableBehavior_%s_allows_tagging_removal', 
              get_class($object)),
      sfConfig::get('app_deppPropelActAsTaggableBehaviorPlugin_allows_tagging_removal', 'all'));
    $tagging_removal_credentials =  sfConfig::get(
      sprintf('propel_behavior_deppPropelActAsTaggableBehavior_%s_tagging_removal_credentials', 
              get_class($object)),
      sfConfig::get('app_deppPropelActAsTaggableBehaviorPlugin_tagging_removal_credentials', array()));
    $use_unique_triple_values =  sfConfig::get(
      sprintf('propel_behavior_deppPropelActAsTaggableBehavior_%s_use_unique_triple_values', 
              get_class($object)),
      sfConfig::get('app_deppPropelActAsTaggableBehaviorPlugin_use_unique_triple_values', false));

    $user = @sfContext::getInstance()->getUser();


    // save new tags
    foreach ($tags as $tagname)
    {
      if ($use_unique_triple_values)
        $tag = TagPeer::retrieveOrCreateByTripleValue($tagname);
      else
        $tag = TagPeer::retrieveOrCreateByTagName($tagname);
      $tag->save();

      $tagging = TaggingPeer::retrieveOrCreateByTagAndTaggable( $tag->getId(), 
                                                                $object->getPrimaryKey(), 
                                                                get_class($object));
      $user_id = deppPropelActAsTaggableToolkit::getUserId();
      if (!$anonymous_tagging && $user->isAuthenticated() &&
          !is_null($user_id) && $user_id != '')
      {    
        if ($tagging->isNew())
          $tagging->setUserId($user_id);
      }
      $tagging->save();        
    }

    // remove removed tags
    $removed_tag_ids = array();
    $c = new Criteria();
    $c->add(TagPeer::NAME, $removed_tags, Criteria::IN);

    if (Propel::VERSION >= '1.3')
    {
      $rs = TagPeer::doSelectStmt($c);

      while ($row = $rs->fetch(PDO::FETCH_ASSOC))
      {
        $removed_tag_ids[] = intval($row['ID']);
      }
    }
    else
    {
      $rs = TagPeer::doSelectRS($c);

      while ($rs->next())
      {
        $removed_tag_ids[] = $rs->getInt(1);
      }
    }


    $c = new Criteria();
    $c->add(TaggingPeer::TAG_ID, $removed_tag_ids, Criteria::IN);
    $c->add(TaggingPeer::TAGGABLE_ID, $object->getPrimaryKey());
    $c->add(TaggingPeer::TAGGABLE_MODEL, get_class($object));
    $user_id = deppPropelActAsTaggableToolkit::getUserId();

    // for authenticated users that do not have tagging_removal_credentials
    // if the only tags they're allowed to remove are their own
    // then, remove only those tags
    // this only works, if anonymnous_tagging is set to false
    if (!$anonymous_tagging && $user->isAuthenticated() &&
        !is_null($user_id) && $user_id != '' && 
        $allows_tagging_removal == 'self' && 
        !$user->hasCredential($tagging_removal_credentials, false))
    {
      $c->add(TaggingPeer::USER_ID, $user_id);
    }
    
    // delete e non doDelete, in modo che anche sul tagging si possano attivare i behavior (per le news)
    // TaggingPeer::doDelete($c);
    $tags_to_delete = TaggingPeer::doSelect($c);
    foreach ($tags_to_delete as $tag_to_delete)
      $tag_to_delete->delete();

    $tags = array_merge(self::get_tags($object), $this->getSavedTags($object));
    self::set_saved_tags($object, $tags);
    self::clear_tags($object);
    self::clear_removed_tags($object);
  }

  /**
   * Taggings removing logic, runned before the object himself has been deleted
   *
   * @param      BaseObject  $object
   */
  public function preDelete(BaseObject $object)
  {
    $object->removeAllTags();
    $object->save();
  }

  /**
   * Preload tags for a set of objects. It might be usefull in case you want to
   * display a long list of taggable objects with their associated tags: it
   * avoids to load tags per object, and gets all tags in a few requests.
   *
   * @param      array       $objects
   */
  public static function preloadTags(&$objects)
  {
    $searched = array();

    foreach ($objects as $object)
    {
      $class = get_class($object);

      if (!isset($searched[$class]))
      {
        $searched[$class] = array();
      }

      $searched[$class][$object->getPrimaryKey()] = $object;
    }

    if (count($searched) > 0)
    {
      $con = Propel::getConnection();

      foreach ($searched as $model => $instances)
      {
        array_map(array('deppPropelActAsTaggableBehavior', 'set_saved_tags'),
                  $instances,
                  array_fill(0, count($instances), array()));
        $keys = array_keys($instances);
        $query = 'SELECT %s as id,
                         GROUP_CONCAT(%s) as tags
                  FROM %s, %s
                  WHERE %s IN (%s)
                  AND %s=?
                  AND %s=%s
                  GROUP BY %s';

        $query = sprintf($query,
                         TaggingPeer::TAGGABLE_ID,
                         TagPeer::NAME,
                         TaggingPeer::TABLE_NAME,
                         TagPeer::TABLE_NAME,
                         TaggingPeer::TAGGABLE_ID,
                         implode($keys, ','),
                         TaggingPeer::TAGGABLE_MODEL,
                         TaggingPeer::TAG_ID,
                         TagPeer::ID,
                         TaggingPeer::TAGGABLE_ID);
        $stmt = $con->prepareStatement($query);
        $stmt->setString(1, $model);

        if (Propel::VERSION >= '1.3')
        {
          $rs = $stmt->executeQuery();

          while ($rs->next())
          {
            $object = $instances[$rs->getInt('id')];
            $object_tags = explode(',', $rs->getString('tags'));
            $tags = array();

            foreach ($object_tags as $tag)
            {
              $tags[$tag] = $tag;
            }

            self::set_saved_tags($object, $tags);
          }
        }
        else
        {
          $rs = $con->query($sql);

          while ($row = $rs->fetch(PDO::FETCH_ASSOC))
          {
            $object = $instances[$row['id']];
            $object_tags = explode(',', $row['tags']);
            $tags = array();

            foreach ($object_tags as $tag)
            {
              $tags[$tag] = $tag;
            }

            self::set_saved_tags($object, $tags);
          }
        }
      }
    }
  }

  /**
   * Removes all the tags associated to the object.
   *
   * @param      BaseObject  $object
   */
  public function removeAllTags(BaseObject $object)
  {
    $saved_tags = self::getSavedTags($object);

    self::set_saved_tags($object, array());
    self::set_tags($object, array());
    self::set_removed_tags($object,
                           array_merge(self::get_removed_tags($object),
                                       $saved_tags));
  }

  /**
   * Removes a tag or a set of tags from the object. As usual, the second
   * parameter might be an array of tags or a comma-separated string.
   *
   * @param      BaseObject  $object
   * @param      mixed       $tagname
   */
  public function removeTag(BaseObject $object, $tagname)
  {
    $tagname = deppPropelActAsTaggableToolkit::explodeTagString($tagname);

    if (is_array($tagname))
    {
      foreach ($tagname as $tag)
      {
        $this->removeTag($object, $tag);
      }
    }
    else
    {
      $tagname = deppPropelActAsTaggableToolkit::cleanTagName($tagname);
      $tags = self::get_tags($object);
      $saved_tags = $this->getSavedTags($object);

      if (isset($tags[$tagname]))
      {
        unset($tags[$tagname]);
        self::set_tags($object, $tags);
      }

      if (isset($saved_tags[$tagname]))
      {
        unset($saved_tags[$tagname]);
        self::set_saved_tags($object, $saved_tags);
        self::add_removed_tag($object, $tagname);
      }
    }
  }

  /**
   * Replaces a tag with an other one. If the third optionnal parameter is not
   * passed, the second tag will simply be removed
   *
   * @param      BaseObject  $object
   * @param      String      $tagname
   * @param      String      $replacement
   */
  public function replaceTag(BaseObject $object, $tagname, $replacement = null)
  {
    if (($replacement != $tagname) && ($tagname != null))
    {
      $this->removeTag($object, $tagname);

      if ($replacement != null)
      {
        $this->addTag($object, $replacement);
      }
    }
  }

  /**
   * Sets the tags of an object. As usual, the second parameter might be an
   * array of tags or a comma-separated string.
   *
   * @param      BaseObject  $object
   * @param      mixed       $tagname
   */
  public function setTags(BaseObject $object, $tagname)
  {
    $this->removeAllTags($object);
    $this->addTag($object, $tagname);
  }
}