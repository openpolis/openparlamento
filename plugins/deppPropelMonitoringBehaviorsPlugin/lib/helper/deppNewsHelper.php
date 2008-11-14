<?php 

/*
 * This file is part of the deppPropelMonitoringBehaviors package.
 * (c) 2008 Guglielmo Celata
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * @package    deppPropelMonitoringBehaviors
 * @author     Guglielmo Celata <guglielmo.celata@symfony-project.com>
 * @version    SVN: $Id$
 */


function news($news)
{
  $news_string = $news->getDate('d/m/Y') . " - ";
  
  // fetch del modello e dell'oggetto che ha generato la notizia
  $generator_model = $news->getGeneratorModel();
  $pks = array_values(unserialize($news->getGeneratorPrimaryKeys()));
  $generator = call_user_func_array($generator_model.'Peer::retrieveByPK', $pks);


  $related_monitorable_model = $news->getRelatedMonitorableModel();
  if ($related_monitorable_model == 'OppPolitico')
  {
    // fetch del politico
    $c = new Criteria(); $c->add(OppPoliticoPeer::ID, $news->getRelatedMonitorableId());
    $politici = OppPoliticoPeer::doSelect($c);
    $politico = $politici[0];

    // link al politico
    $politico_link = link_to($politico->getNome() . ' ' .$politico->getCognome(), 
                         '@parlamentare?id=' . $politico->getId(),
                         array('title' => 'Vai alla scheda del politico'));


    // nuovo incarico
    if ($generator_model == 'OppCarica'){
      $news_string .= $politico_link . " ha assunto l'incarico di " . $generator->getCarica();
    }
    
    // nuovo gruppo
    if ($generator_model == 'OppCaricaHasGruppo'){
      $news_string .= $politico_link . " si &egrave; unito al gruppo " . $generator->getOppGruppo()->getNome();
    }
    
  }
  
  if ($related_monitorable_model == 'OppAtto')
  {
    // fetch dell'atto
    $c = new Criteria(); $c->add(OppAttoPeer::ID, $news->getRelatedMonitorableId());
    $atti = OppAttoPeer::doSelectJoinOppTipoAtto($c);
    $atto = $atti[0];
    
    // tipo di atto e genere per gli articoli e la desinenza
    $tipo = $atto->getOppTipoAtto();
    if (in_array($tipo->getId(), array(1, 10, 11)))
      $gender = 'm';
    else
      $gender = 'f';

    // link all'atto
    $atto_link = link_to($atto->getRamo() . '.' .$atto->getNumfase(), 
                         'atto/ddlIndex?id=' . $atto->getId(),
                         array('title' => $atto->getTitolo()));
    
    // presentazione
    if ($generator_model == 'OppAtto'){
      $news_string .= "presentat" .($gender=='m'?'o':'a') . " ";
      $news_string .= $tipo->getDenominazione() . " ";
      $news_string .= $atto_link;
    }
    
    // votazione finale
    if ($generator_model == 'OppVotazioneHasAtto'){
      $news_string .= ' si &egrave; svolta la votazione finale relativa a ';
      $news_string .= $tipo->getDenominazione() . " ";
      $news_string .= $atto_link;
    }
    
    // status conclusivo
    if ($generator_model == 'OppAttoHasIter'){
      $news_string .= "l'iter del" .($gender=='m'?"l'":"la ");
      $news_string .= $tipo->getDenominazione() . " ";
      $news_string .= $atto_link . " ";
      $news_string .= "si &egrave; concluso. ";
      $news_string .= content_tag('b', ucfirst(strtolower($generator->getOppIter()->getFase())));
    }
    
    
                                  
   // fetch dell'id del generatore
    
    
  }
  
  return $news_string;
  
}


?>