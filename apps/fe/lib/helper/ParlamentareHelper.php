<?php

function ribelleStyle($voto_parlamentare, $voto_gruppo)
{
  if($voto_parlamentare!=$voto_gruppo && $voto_parlamentare!=sfConfig::get('app_voto_6') && 
     $voto_parlamentare!=sfConfig::get('app_voto_7') && $voto_parlamentare!=sfConfig::get('app_voto_8') && 
	 $voto_parlamentare!=sfConfig::get('app_voto_9') && $voto_parlamentare!=sfConfig::get('app_voto_5') && $voto_parlamentare!=sfConfig::get('app_voto_1'))
	   echo 'ribelli';
  else
       echo '';	   
}

?>