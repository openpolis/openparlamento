<?php
/**
 * monitoring components.
 *
 * @package    openparlamento
 * @subpackage monitoring
 * @author     Guglielmo Celata
 * @version    SVN: $Id: components.class.php 1415 2006-06-11 08:33:51Z fabien $
 */
class monitoringComponents extends sfComponents
{
  public function executeSubmenu()
  {
    $this->sub_menu_items = array('tags' => 'Argomenti',
                                  'acts' => 'Atti',
                                  'politicians' => 'Politici',
                                  'bookmarks' => 'Preferiti');
  }
}

?>
