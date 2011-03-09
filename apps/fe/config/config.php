<?php

// include project configuration
include(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

// symfony bootstraping
require_once($sf_symfony_lib_dir.'/util/sfCore.class.php');
sfCore::bootstrap($sf_symfony_lib_dir, $sf_symfony_data_dir);

// wikifiable behavior: hook per metodi preSave e postSave
// aggiunge descrizione in pagina wiki dopo la creazione di un atto o votazione
// la descrizione è aggiunta solo se si tratta di un nuovo oggetto (non per update)
sfPropelBehavior::registerHooks('wikifiableBehavior', array(
  ':save:pre'                => array('wikifiableBehavior', 'preSave'),
  ':save:post'               => array('wikifiableBehavior', 'postSave'),  
  ':delete:pre'               => array('wikifiableBehavior', 'preDelete'),    
));

// force tagging OppAttos related to an OppEmendamento 
// with all the tags assigned to the OppEmendamento
//sfMixer::register('BaseTagging:save:post',
                 // array('OppTaggingExtension', 'propagateTagsToRelatedAttos'));

// need to include this to use the api.yml config file
require_once(sfConfigCache::getInstance()->checkConfig('config/api.yml'));


// blocco temporaneo degli accessi
// per attivarlo/disattivarlo, basta modificare apps/fe/setings.yml
// e aggiungere il modulo deppTemporaryBlock all'elenco di quelli enabled
if (in_array('deppTemporaryBlock', sfConfig::get('sf_enabled_modules', array())))
{
  $r = sfRouting::getInstance();

  // preprend our routes
  $r->prependRoute('block_login', '/login', array('module' => 'deppTemporaryBlock', 'action' => 'block'));
  $r->prependRoute('block_request_password', '/request_password', array('module' => 'deppTemporaryBlock', 'action' => 'block'));
}
