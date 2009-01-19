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

  if (is_null($news->getGeneratorPrimaryKeys()))
  {
    if ($generator_model == 'OppVotazioneHasAtto')
    {
      if ($news->getPriority() == 1)
      {
        $news_string .= 'si &egrave; svolta almeno una VOTAZIONE';
        $news_string .= ($news->getRamoVotazione()=='C')?' alla Camera ' : ' al Senato ';        
      } else {
        $news_string .= 'si &egrave; svolta una VOTAZIONE';
        $news_string .= ($news->getRamoVotazione()=='C')?' alla Camera ' : ' al Senato ';        
        $news_string .= 'per ' . OppTipoAttoPeer::retrieveByPK($news->getTipoAttoId())->getDenominazione() .  ' ';
        
        // link all'atto
        $atto = call_user_func_array(array($news->getRelatedMonitorableModel().'Peer', 'retrieveByPK'), 
                                           $news->getRelatedMonitorableId());
        
        $atto_link = link_to($atto->getRamo() . '.' .$atto->getNumfase(), 
                             'atto/index?id=' . $atto->getId(),
                             array('title' => $atto->getTitolo()));
        $news_string .= $atto_link;
      }
    } else if ($generator_model == 'OppIntervento') {
      $news_string .= 'c\'&egrave; stato almeno un intervento ';
      $news_string .= 'in ' . OppSedePeer::retrieveByPK($news->getSedeInterventoId())->getDenominazione() .  ' ';
      $news_string .= 'per ' . OppTipoAttoPeer::retrieveByPK($news->getTipoAttoId())->getDenominazione() .  ' ';

      // link all'atto
      $atto = call_user_func_array(array($news->getRelatedMonitorableModel().'Peer', 'retrieveByPK'), 
                                         $news->getRelatedMonitorableId());
      
      $atto_link = link_to($atto->getRamo() . '.' .$atto->getNumfase(), 
                           'atto/index?id=' . $atto->getId(),
                           array('title' => $atto->getTitolo()));
      $news_string .= $atto_link;
      
    }
      
    return $news_string;
  }
  
  $pks = array_values(unserialize($news->getGeneratorPrimaryKeys()));
  $generator = call_user_func_array(array($generator_model.'Peer', 'retrieveByPK'), $pks);


  $related_monitorable_model = $news->getRelatedMonitorableModel();
  if ($related_monitorable_model == 'OppPolitico')
  {
    // fetch del politico
    $c = new Criteria(); $c->add(OppPoliticoPeer::ID, $news->getRelatedMonitorableId());
    $politici = OppPoliticoPeer::doSelect($c);

    if (count($politici) == 0) return 'empty OppPolitico:' . $news->getRelatedMonitorableId();

    $politico = $politici[0];

    // link al politico
    $politico_link = link_to($politico->getNome() . ' ' .$politico->getCognome(), 
                         '@parlamentare?id=' . $politico->getId(),
                         array('title' => 'Vai alla scheda del politico'));


    // nuovo incarico
    if ($generator_model == 'OppCarica'){
      $news_string .= $politico_link . " assume l'incarico di " . $generator->getCarica();
    }
    
    // nuovo gruppo
    else if ($generator_model == 'OppCaricaHasGruppo'){
      $news_string .= $politico_link . " si unisce al gruppo " . $generator->getOppGruppo()->getNome();
    }

    // intervento
    else if ($generator_model == 'OppIntervento'){
      $atto = $generator->getOppAtto();
      $tipo = $atto->getOppTipoAtto();
      $atto_link = link_to($atto->getRamo() . '.' .$atto->getNumfase(), 
                           'atto/index?id=' . $atto->getId(),
                           array('title' => $atto->getTitolo()));
                           
      $news_string .= $politico_link . " interviene su ";
      $news_string .= $tipo->getDenominazione() . " ";
      $news_string .= $atto_link;
    }

    // firma
    else if ($generator_model == 'OppCaricaHasAtto'){
      $atto = $generator->getOppAtto();
      $tipo = $atto->getOppTipoAtto();
      $atto_link = link_to($atto->getRamo() . '.' .$atto->getNumfase(), 
                           'atto/index?id=' . $atto->getId(),
                           array('title' => $atto->getTitolo()));
                           
      $news_string .= $politico_link . " firma ";
      $news_string .= $tipo->getDenominazione() . " ";
      $news_string .= $atto_link;
    }

    else $news_string .= $generator_model;
    
  }
  
  if ($related_monitorable_model == 'OppAtto')
  {
    // fetch dell'atto
    $c = new Criteria(); $c->add(OppAttoPeer::ID, $news->getRelatedMonitorableId());
    $atti = OppAttoPeer::doSelectJoinOppTipoAtto($c);

    // detect a void query
    if (count($atti) == 0) return 'empty OppAtto:' . $news->getRelatedMonitorableId();

    $atto = $atti[0];
    
    // tipo di atto e genere per gli articoli e la desinenza
    $tipo = $atto->getOppTipoAtto();
    if (in_array($tipo->getId(), array(1, 10, 11)))
      $gender = 'm';
    else
      $gender = 'f';

    // link all'atto
    $atto_link = link_to($atto->getRamo() . '.' .$atto->getNumfase(), 
                         'atto/index?id=' . $atto->getId(),
                         array('title' => $atto->getTitolo()));
    
    // presentazione
    if ($generator_model == 'OppAtto'){
      $news_string .= "presentat" .($gender=='m'?'o':'a') . " ";
      $news_string .= $tipo->getDenominazione() . " ";
      $news_string .= $atto_link;
    }
    
    // intervento
    else if ($generator_model == 'OppIntervento'){
      $politico = $generator->getOppCarica()->getOppPolitico();
      $politico_link = link_to($politico, 
                           '@parlamentare?id=' . $politico->getId(),
                           array('title' => 'Vai alla scheda del politico'));
                           
      $news_string .= $politico_link . " interviene su ";
      $news_string .= $tipo->getDenominazione() . " ";
      $news_string .= $atto_link;
    }

    // firma
    else if ($generator_model == 'OppCaricaHasAtto'){
      $politico = $generator->getOppCarica()->getOppPolitico();
      $politico_link = link_to($politico, 
                           '@parlamentare?id=' . $politico->getId(),
                           array('title' => 'Vai alla scheda del politico'));

      $news_string .= ' firmat' . ($gender=='m'?'o':'a') . " ";
      $news_string .= $tipo->getDenominazione() . " ";
      $news_string .= $atto_link;
      $news_string .= " da " . $politico_link;      
    }
    
    // spostamento in commissione
    else if ($generator_model == 'OppAttoHasSede'){
      $news_string .= $tipo->getDenominazione() . " ";
      $news_string .= $atto_link . " ";
      $news_string .= "&egrave; spostat" . ($gender=='m'?'o':'a') . " in ";
      $news_string .= content_tag('b', ucfirst(strtolower($generator->getOppSede()->getDenominazione())));
    }
    
    // votazioni
    else if ($generator_model == 'OppVotazioneHasAtto'){
      $news_string .= ' si &egrave; svolta la votazione finale relativa a ';
      $news_string .= $tipo->getDenominazione() . " ";
      $news_string .= $atto_link;        
    }
    
    // status conclusivo
    else if ($generator_model == 'OppAttoHasIter'){
      $news_string .= "lo status del" .($gender=='m'?"l'":"la ");
      $news_string .= $tipo->getDenominazione() . " ";
      $news_string .= $atto_link . " ";
      $news_string .= "&egrave; ora ";
      $news_string .= content_tag('b', ucfirst(strtolower($generator->getOppIter()->getFase())));
    } 
    
    else $news_string .= $generator_model;
                                  
    
    
  }
  
  return $news_string;
  
}


?>