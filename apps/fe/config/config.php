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

// need to include this to use the api.yml config file
require_once(sfConfigCache::getInstance()->checkConfig('config/api.yml'));
