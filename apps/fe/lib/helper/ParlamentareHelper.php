<?php

function link_to_politicoNomeTipoFromCaricaId($carica_id, $relevance)
{
  $carica = OppCaricaPeer::retrieveByPK($carica_id);
  
  if ($carica)
  {
    $politico = $carica->getOppPolitico();
    $str = $politico->__toString();    
  } else {
    return "impossibile trovare carica per $carica_id";
  }
  
  $c = new Criteria();
  $c->add(OppCaricaHasGruppoPeer::CARICA_ID, $carica_id);
  $c->add(OppCaricaHasGruppoPeer::DATA_FINE,NULL);
  $gruppo_attuale = OppCaricaHasGruppoPeer::doSelectOne($c);
  
  $str = $str. " (".$gruppo_attuale->getOppGruppo()->getAcronimo().")";

  // Visualizzazione dell'indice di rilevanza
  $punteggio = $relevance['punteggio'];
  return link_to($str, '@parlamentare?'.$politico->getUrlParams(), array('class' => 'folk2', 'title' => "punteggio: " . $punteggio));
}

function ribelleStyle($voto_parlamentare, $voto_gruppo)
{
  if( ($voto_gruppo == 'Favorevole' || $voto_gruppo == 'Astenuto' || $voto_gruppo == 'Contrario')
      && $voto_gruppo != $voto_parlamentare ) 
  {  
    if($voto_parlamentare=='Favorevole' || $voto_parlamentare=='Astenuto' || $voto_parlamentare=='Contrario')
      echo 'ribelli';
    else
       echo '';
  }     	   
}

?>