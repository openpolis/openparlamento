<?php

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Nicolas Chambrier <naholyr@yahoo.fr>
 * @version    SVN: $Id$
 */

// autoloading for plugin lib actions is broken as at symfony-1.0.2
require_once(sfConfig::get('sf_plugins_dir'). '/nahoWikiPlugin/modules/nahoWiki/lib/BasenahoWikiActions.class.php');

class nahoWikiActions extends BasenahoWikiActions
{
}
