<table class="disegni-decreti column-table lazyload">
  <thead>
    <tr>
      <th scope="col">parlamentare:</th>
      <th scope="col">indice di attivit&agrave;:</th> 	
      <th scope="col">voti ribelli:</th>			
      <th scope="col" class="evident">presenze:</th>			
      <th scope="col" class="evident">assenze:</th>
      <th scope="col" class="evident">missioni:</th>
      <th scope="col">circoscrizione:</th>
      <th scope="col">utenti che lo seguono:</th>
    </tr>
  </thead>

  <tbody>
<?php    
foreach ($gruppo_now as $k => $g)
{
  if ($g!==0)
  {
    echo OppGruppoPeer::retrieveByPk($k)->getNome()." Ora: ".$g." entranti: ".$gruppo_in[$k]." uscenti: ".$gruppo_out[$k]." saldo:".($gruppo_in[$k]-$gruppo_out[$k]);
    echo "<br/>";
  }
  
}

echo "<br/><br/><br/>";

foreach($array_diff as $k => $diff)
{
  echo OppGruppoPeer::retrieveByPk($k)->getNome();
   echo "<br/>";
  foreach ($diff as $k1 => $d)
  {
    echo OppGruppoPeer::retrieveByPk($k1)->getNome()."*".$d;
     echo "<br/>";
  }
  echo "<br/><br/><br/>";
}


?>