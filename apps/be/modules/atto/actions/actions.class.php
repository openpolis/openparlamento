<?php

/**
 * atto actions.
 *
 * @package    op_openparlamento
 * @subpackage atto
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2288 2006-10-02 15:22:13Z fabien $
 */
class attoActions extends autoattoActions
{
  protected function saveOppAtto($opp_atto)
  {
    $opp_atto->save();

    // commit changes
    $indexManager = sfSolr::getInstance();
    $indexManager->commit();
    

  }

  protected function deleteOppAtto($opp_atto)
  {
    $opp_atto->delete();

    // commit changes
    $indexManager = sfSolr::getInstance();
    $indexManager->commit();
  }
  
}
