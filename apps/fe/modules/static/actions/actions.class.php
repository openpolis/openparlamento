<?php

/**
 * static actions.
 *
 * @package    op_openparlamento
 * @subpackage static
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class staticActions extends sfActions
{

  public function executeBloccoTemporaneo()
  {
    # code...
  }

  public function executeProgetto()
  {
    $this->getResponse()->setTitle('il progetto | '.sfConfig::get('app_main_title')); 
  }
  public function executeChisiamo()
  {
    $this->getResponse()->setTitle('chi siamo | '.sfConfig::get('app_main_title')); 
  }
  public function executeContatti()
  {
    $this->getResponse()->setTitle('contatti | '.sfConfig::get('app_main_title')); 
  }
  public function executeFaq()
  {
    $this->getResponse()->setTitle('faq | '.sfConfig::get('app_main_title'));
  }
  public function executeRegolamento()
  {
    $this->getResponse()->setTitle('regolamento | '.sfConfig::get('app_main_title'));
  }
  public function executeCondizioni()
  {
    $this->getResponse()->setTitle('condizioni d\'uso | '.sfConfig::get('app_main_title')); 
  }
  public function executeInformativa()
  {
    $this->getResponse()->setTitle('informativa sui dati personali | '.sfConfig::get('app_main_title')); 
  }
  public function executeRssxml()
  {
    $this->getResponse()->setTitle('rss/xml | '.sfConfig::get('app_main_title')); 
  }
  public function executeInizia()
  {
    $this->getResponse()->setTitle('cosa posso fare? | '.sfConfig::get('app_main_title')); 
  }
  
  public function executeTesseramento()
  {
    $this->getResponse()->setTitle('diventa socio di openpolis | '.sfConfig::get('app_main_title')); 
  }
  
  public function execute404()
  {
    $this->getResponse()->setTitle('pagina non trovata | '.sfConfig::get('app_main_title')); 
  }

  public function executeUnavailable()
  {
    $this->getResponse()->setTitle('applicazione sospesa | '.sfConfig::get('app_main_title')); 
  }
  
}
