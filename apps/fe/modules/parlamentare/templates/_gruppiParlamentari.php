<table class="disegni-decreti column-table lazyload">
  <thead>
    <tr>
      <th scope="col">Gruppo:</th>
      <th scope="col">Attuali:</th> 	
      <th scope="col">Entranti:</th>
      <th scope="col">Uscenti:</th>
      <th scope="col">Saldo:</th>
    </tr>
  </thead>

  <tbody>
<?php    
foreach ($gruppo_now as $k => $g)
{
  if ($g!==0)
  {
    echo "<tr>";
    echo "<td>".OppGruppoPeer::retrieveByPk($k)->getNome()."</td>";
    echo "<td>".$g."</td>";
    echo "<td>".$gruppo_in[$k]."</td>";
    echo "<td>".$gruppo_out[$k]."</td>";
    echo "<td>".($gruppo_in[$k]-$gruppo_out[$k])."</td>";
    echo "</tr>";
  }
  
}
?>
 </tbody>
</table> 

<table border=1>
  <tbody>
  <tr>
  <td></td>  
<?php
echo "<br/><br/><br/>";

foreach($array_diff as $k => $diff)
{
  $pos[]=$k;
  echo "<td>".OppGruppoPeer::retrieveByPk($k)->getAcronimo()."</td>";
}
echo "</tr>";  

foreach($array_diff as $k => $diff)
{
  echo "<tr><td>".OppGruppoPeer::retrieveByPk($k)->getAcronimo()."</td>";
  echo "=====".$k."===============\n";
  var_dump($diff);
  echo "<br/>";
  for ($x=0;$x<count($array_diff);$x++)
  {

    if (array_key_exists($pos[$x],$diff))
      echo "<td>".$diff[$pos[$x]]."</td>";
    else
      echo "<td>0</td>";
   
  }
  echo "</tr>";
  /*
  foreach ($diff as $k1 => $d)
  {
    echo OppGruppoPeer::retrieveByPk($k1)->getNome()."*".$d;
     echo "<br/>";
  }
  */
}

?>
</tbody>
</table>