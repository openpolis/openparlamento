<?php
require_once(dirname(__FILE__).'/../../../../../plugins/deppPropelActAsTaggableBehaviorPlugin/modules/deppTagging/lib/BasedeppTaggingActions.class.php');

/**
  * deppPropelActAsTaggableBehaviorPlugin actions. 
  * Feel free to override this class in your dedicated app module.
 *
 * @package    plugins
 * @subpackage deppPropelActAsTaggableBehaviorPlugin
 * @author     Guglielmo Celata
 */
class deppTaggingActions extends BasedeppTaggingActions
{

    public function executeEditAjax()
    {
      // fetch request parameters and taggable content
      $content_id = $this->getRequestParameter('content_id');
      $content_peer = $this->getRequestParameter('content_type') . 'Peer';
      $content = call_user_func(array($content_peer, 'retrieveByPK'), $content_id);

      // store tags passed in the input field and teseo tags into DB
  	  $teseo_triple_tags = $content->getTags(array('is_triple' => true,
                                                   'namespace' => 'teseo',
                                                   'key'       => 'tag',
                                                   'return'    => 'tag'));
      $tags_as_string = deppPropelActAsTaggableToolkit::transformTagStringIntoTripleString(strip_tags($this->getRequestParameter('usertags')), 'user', 'tag');
      $teseo_triple_tags_as_string = deppPropelActAsTaggableToolkit::getTagsAsString($teseo_triple_tags); 
      $complete_tags_string = $tags_as_string . 
        ( count($teseo_triple_tags)>0 ?", $teseo_triple_tags_as_string":'') ;

      // a setTags remove the tags and add them back
      // but it's only possible to remove others' tags while moderator (it's embedded in the save() method)
      // and a moderator always has others' tags in the input field
      $content->setTags($complete_tags_string);
      $content->save();

      // get all tags, forcing the cache override (directly from the DB)
      $tags = $content->getTags(array('is_triple' => true,
                                      #'namespace' => 'user',
                                      'key'       => 'tag',
                                      'return'    => 'value'),
                                true);

      // if necessary, get users' tags
      $anonymous_tagging =  sfConfig::get(
        sprintf('propel_behavior_deppPropelActAsTaggableBehavior_%s_anonymous_tagging', 
                get_class($content)),
        sfConfig::get('app_deppPropelActAsTaggableBehaviorPlugin_anonymous_tagging', true));
      $user = @sfContext::getInstance()->getUser();

      $user_tags = array();
      $user_id = deppPropelActAsTaggableToolkit::getUserId();
      if (!$anonymous_tagging && $user->isAuthenticated() &&
          !is_null($user_id) && $user_id !== '')
      {
    	  $user_tags = $content->getUserTags(array('is_triple' => true,
                                                 'namespace' => 'user',
                                                 'key'       => 'tag',
                                                 'return'    => 'value'),
                                            $user_id);      
      } 	

  	  $teseo_tags = $content->getTags(array('is_triple' => true,
  	                                        'namespace' => 'teseo',
                                            'key'       => 'tag',
                                            'return'    => 'value'));

      // set the value to be returned by AJAX
      // it's the visible string, with <spam> tags  
      $this->value = deppPropelActAsTaggableToolkit::getTagsAsTaggedString(
          array('other' => array_diff($tags, $user_tags, $teseo_tags),
                'user'  => $user_tags,
                'teseo' => $teseo_tags));
    }

    public function executeEditableTagsAutocomplete() {
  		$this->my_str = $this->getRequestParameter('value');

  		$c = new Criteria();
  		$c->add(TagPeer::TRIPLE_VALUE, $this->my_str."%", Criteria::LIKE);
  		$this->tags = TagPeer::getAll($c, array('is_triple' => true, 
  		                                        'key'       => 'tag', 
  		                                        'return' => 'value'));

  	}

}
