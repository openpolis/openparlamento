<?php

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