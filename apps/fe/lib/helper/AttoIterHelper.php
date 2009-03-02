<?php

function NomeIter($denominazione,$ramo)
{ 
  if ($ramo=='C') {
      $ramo1=' alla Camera';
      $ramo2=' dalla Camera';
  }    
  else {
       $ramo1=' in Senato';
       $ramo2=' dal Senato';
  }     
  
  switch ($denominazione) {
  	case "assorbito" :
  	$nome_iter="assorbito ".$ramo1;
	break;
	case "respinto" :
	$nome_iter="respinto ".$ramo2;
	break;
	case "ritirato" :
	$nome_iter="ritirato".$ramo1;
	break;
	case "decreto legge decaduto" :
	$nome_iter="DL decaduto";
	break;
	case "approvato definitivamente. Legge" :
	$nome_iter="divenuto legge";
	break;
	case "approvato definitivamente, non ancora pubblicato" :
	$nome_iter="approvato".$ramo2;
	break;
	case "conclusione anomala per stralcio" :
	$nome_iter="concluso per stralcio";
	break;
	case "cancellato dall'Ordine del Giorno" :
	$nome_iter="cancellato dall'ODG".$ramo1;
	break;
	case "rinviato alle Camere dal Presidente della Repubblica" :
	$nome_iter="rinviato dal Pres. Repub.";
	break;
	case "approvato" :
	$nome_iter="approvato".$ramo2;
	break;
	case "restituito al Governo per essere ripresentato all'altro ramo" :
	$nome_iter="da ripresentare";
	break;
	case "approvato con modificazioni" :
	$nome_iter="modificato".$ramo1;
	break;
	case "approvato in testo unificato" :
	$nome_iter="appr. in TU".$ramo2;
	break;
	case "convertito in legge" :
	$nome_iter="Convertito in legge";
	break;
	case "Confluito in altro Decreto Legge" :
	$nome_iter="confluito in altro DL";
	break;
	case "Entrato in vigore" :
	$nome_iter="entrato in vigore";
	break;
	default:
	$nome_iter=$denominazione;
     }	
     return $nome_iter;
}

?>