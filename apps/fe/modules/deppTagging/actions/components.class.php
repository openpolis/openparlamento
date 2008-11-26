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


    // fetch di TUTTI i tag legati al content (come nomi completi di triple)
    $this->tags = $this->content->getTags(array('is_triple' => true));
    
    // sono considerati teseo_tags tutti i tag con ns teseo e geoteseo
	  $teseo_tags = $this->content->getTags(array('is_triple' => true,
                                                'namespace' => 'teseo',
                                                'return'    => 'value'));

	  $geo_tags = $this->content->getTags(array('is_triple' => true,
                                              'namespace' => 'geoteseo',
                                              'return'    => 'value'));
    $this->teseo_tags = array_merge($teseo_tags, $geo_tags);


    // tag aggiunti da utenti reali (user_id in not null)
	  $this->user_tags = $this->content->getUserTags(array('is_triple' => true,
                                                   'return'    => 'value'));
                                                   

    $user = @sfContext::getInstance()->getUser();
    $user_id = deppPropelActAsTaggableToolkit::getUserId();


    // i removable_tags sono quelli aggiunti dagli utenti (di default)
    if ($user->isAuthenticated())
      $this->removable_tags = $this->user_tags;
    else
      $this->removable_tags = array();    
    
    // tag aggiunti dall'utente loggato e override eventuale dei removable_tags 
    // (se la configurazione lo prevede)
    $this->my_tags = array(); 
    if (!$anonymous_tagging && $user->isAuthenticated() &&
        !is_null($user_id) && $user_id !== '')
    {
  	  $this->my_tags = $this->content->getUserTags(array('is_triple' => true,
                                                           'return'    => 'value'),
                                                   $user_id);
      if ($allows_tagging_removal == 'self' &&
          !$user->hasCredential($tagging_removal_credentials, false))      
        $this->removable_tags = $this->my_tags;
    }

	  $this->anonymous_tagging = $anonymous_tagging;
	  $this->allows_tagging_removal = $allows_tagging_removal;
	  $this->tagging_removal_credentials = $tagging_removal_credentials;
	}	

  
}