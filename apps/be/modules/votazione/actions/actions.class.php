<?php

/**
 * votazione actions.
 *
 * @package    openparlamento
 * @subpackage votazione
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2288 2006-10-02 15:22:13Z fabien $
 */
class votazioneActions extends autovotazioneActions
{
  protected function saveOppVotazione($opp_votazione)
  {
    $opp_votazione->save();

    // commit changes
    $indexManager = sfSolr::getInstance();
    $indexManager->commit();
    
  }

  protected function deleteOppVotazione($opp_votazione)
  {
    $opp_votazione->delete();

    // commit changes
    $indexManager = sfSolr::getInstance();
    $indexManager->commit();
    
  }

  
}
