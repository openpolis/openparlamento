<?php
require_once(dirname(__FILE__).'/../../../../../plugins/deppPropelActAsTaggableBehaviorPlugin/modules/deppTagging/lib/BasedeppTaggingComponents.class.php');

/**
 * deppPropelActAsTaggableBehaviorPlugin base componente
 * 
 * @package    plugins
 * @subpackage deppPropelActAsTaggableBehaviorPlugin
 */
class deppTaggingComponents extends BasedeppTaggingComponents
{

  public function executeEdit()
	{

    // embed javascripts for edit-in-place and auto-completer
	  $response = sfContext::getInstance()->getResponse();
    $response->addJavascript('prototype.js');
    $response->addJavascript('effects.js');
    $response->addJavascript('controls.js');
    $response->addStylesheet('/deppPropelActAsTaggableBehaviorPlugin/css/depp_tagging.css');
    
    

    // read some config parameters and defaults
    $anonymous_tagging =  sfConfig::get(
      sprintf('propel_behavior_deppPropelActAsTaggableBehavior_%s_anonymous_tagging', 
              get_class($this->content)),
      sfConfig::get('app_deppPropelActAsTaggableBehaviorPlugin_anonymous_tagging', true));
    $allows_tagging_removal =  sfConfig::get(
      sprintf('propel_behavior_deppPropelActAsTaggableBehavior_%s_allows_tagging_removal', 
              get_class($this->content)),
      sfConfig::get('app_deppPropelActAsTaggableBehaviorPlugin_allows_tagging_removal', 'all'));
    $tagging_removal_credentials =  sfConfig::get(
      sprintf('propel_behavior_deppPropelActAsTaggableBehavior_%s_tagging_removal_credentials', 
              get_class($this->content)),
      sfConfig::get('app_deppPropelActAsTaggableBehaviorPlugin_tagging_removal_credentials', array()));
    $user = @sfContext::getInstance()->getUser();

	  $tags = $this->content->getTags(array('is_triple' => true,
                                          'namespace' => 'user',
                                          'key'       => 'tag',
                                          'return'    => 'value'));

	  $teseo_tags = $this->content->getTags(array('is_triple' => true,
                                                'namespace' => 'teseo',
                                                'key'       => 'tag',
                                                'return'    => 'value'));

    $user_tags = array();
    $this->editable_tags_as_string = deppPropelActAsTaggableToolkit::getTagsAsString($tags);
    $user_id = deppPropelActAsTaggableToolkit::getUserId();
    if (!$anonymous_tagging && $user->isAuthenticated() &&
        !is_null($user_id) && $user_id !== '')
    {
  	  $user_tags = $this->content->getUserTags(array('is_triple' => true,
                                                           'namespace' => 'user',
                                                           'key'       => 'tag',
                                                           'return'    => 'value'),
                                                      $user_id);
      if ($allows_tagging_removal == 'self' &&
          !$user->hasCredential($tagging_removal_credentials, false))      
  	    $this->editable_tags_as_string = deppPropelActAsTaggableToolkit::getTagsAsString($user_tags);
  	  
    }
	  $this->visible_tags_as_string = deppPropelActAsTaggableToolkit::getTagsAsTaggedString(
         array('other' => array_diff($tags, $user_tags, $teseo_tags),
               'user'  => $user_tags,
               'teseo' => $teseo_tags));
    ;
	  $this->anonymous_tagging = $anonymous_tagging;
	  $this->allows_tagging_removal = $allows_tagging_removal;
	  $this->tagging_removal_credentials = $tagging_removal_credentials;
	}	
  
}