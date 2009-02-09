<?php

function link_to_politicoNomeTipoFromCaricaId($carica_id, $relevance)
{
  $carica = OppCaricaPeer::retrieveByPK($carica_id);
  $politico = $carica->getOppPolitico();
  $str = $politico->__toString();
  
  $tipo_carica_id = $carica->getTipoCaricaId();
  if ($tipo_carica_id == 1)
    $str .= " (D)";
  elseif ($tipo_carica_id == 4 || $tipo_carica_id == 5)
    $str .= " (S)";
  else
    $str .= " (G)";
  
  return link_to($str, '@parlamentare?id='.$politico->getId(), array('class' => 'folk2', 'title' => $relevance));
}

function ribelleStyle($voto_parlamentare, $voto_gruppo)
{
  sfLogger::getInstance()->info('xxx: ' . $voto_parlamentare . "-" . $voto_gruppo);
  
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