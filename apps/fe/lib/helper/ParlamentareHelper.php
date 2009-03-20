<?php

function link_to_politicoNomeTipoFromCaricaId($carica_id, $relevance)
{
  $carica = OppCaricaPeer::retrieveByPK($carica_id);
  $politico = $carica->getOppPolitico();
  $str = $politico->__toString();
  
  $c=new Criteria();
  $c->add(OppCaricaHasGruppoPeer::CARICA_ID,$carica_id);
  $c->add(OppCaricaHasGruppoPeer::DATA_FINE,NULL);
  $gruppo_attuale=OppCaricaHasGruppoPeer::doSelectOne($c);
  
  $str=$str. " (".$gruppo_attuale->getOppGruppo()->getAcronimo().")";
  
  // Visualizzazione dell'indice di rilevanza
  //return link_to($str." [".$relevance."]", '@parlamentare?id='.$politico->getId(), array('class' => 'folk2', 'title' => $relevance));
  
  // Visualizza senza indice di rilevanza
    return link_to($str, '@parlamentare?id='.$politico->getId(), array('class' => 'folk2', 'title' => $relevance));
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