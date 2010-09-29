<br/>
<h5 class="subsection">La composizione dei gruppi parlamentari <?php echo ($ramo==1?'della Camera':'del Senato')?> e variazioni nel corso della legislatura</h5>

<table class="disegni-decreti column-table lazyload">
  <thead>
    <tr>
      <th scope="col">Gruppo:</th>
      <th scope="col">Membri<br/>attuali:</th> 	
      <th scope="col">Conquistati:</th>
      <th scope="col">Perduti:</th>
      <th scope="col">Saldo:</th>
    </tr>
  </thead>

  <tbody>
<?php    
$tr_class = 'even';
foreach ($gruppo_now as $k => $g)
{
  if ($g!==0)
  {
    echo "<tr class='".$tr_class."'>";
    $tr_class = ($tr_class == 'even' ? 'odd' : 'even' );
    echo "<th scope='row'>".link_to(OppGruppoPeer::retrieveByPk($k)->getNome(),'@parlamentari?ramo='.($ramo==1?'camera':'senato').'&sort=nome&type=asc&filter_group='.$k)."</th>";
    echo "<td>".link_to($g,'@parlamentari?ramo='.($ramo==1?'camera':'senato').'&sort=nome&type=asc&filter_group='.$k)."</td>";
    echo "<td>".$gruppo_in[$k]."</td>";
    echo "<td>".$gruppo_out[$k]."</td>";
    echo "<td><strong>".(($gruppo_in[$k]-$gruppo_out[$k])>0 ? '+'.($gruppo_in[$k]-$gruppo_out[$k]) : ($gruppo_in[$k]-$gruppo_out[$k]))."</strong></td>";
    echo "</tr>";
  }
  
}
?>
 </tbody>
</table> 
<br/>
<h5 class="subsection">Gruppo VS Gruppo: chi guadagna e chi perde da inizio legislatura ad oggi</h5>
<br/>
<table class="disegni-decreti column-table lazyload">
    <thead>
  <tr>
  <td></td>  
<?php

foreach($array_diff as $k => $diff)
{
  $pos[]=$k;
  echo "<th scope='col'>".OppGruppoPeer::retrieveByPk($k)->getAcronimo()."</th>";
}
echo "<th scope='col'>Saldo</th>";
echo "</tr>";  
echo "</thead>";
echo "<tbody>";
$tr_class = 'even';

foreach($array_diff as $k => $diff)
{
  echo "<tr class='".$tr_class."'>";
  $tr_class = ($tr_class == 'even' ? 'odd' : 'even' );
  echo "<td style='font-size:11px;'><strong>".OppGruppoPeer::retrieveByPk($k)->getAcronimo()."</strong></td>";
  $saldo=0;
  
  for ($x=0;$x<count($array_diff);$x++)
  {
    if (array_key_exists($pos[$x],$diff))
    {
      $saldo=$saldo+$diff[$pos[$x]];
      echo "<td style='border:1px solid #DFE0E0;'>".(($diff[$pos[$x]]>0) ? '+'.$diff[$pos[$x]] : $diff[$pos[$x]])."</td>";
    }
    else
    {
      if ($pos[$x]==$k)
        echo "<td class='evident' style='border:1px solid #DFE0E0;'>&nbsp;</td>";
      else
        echo "<td style='border:1px solid #DFE0E0;'>0</td>";
    }
      
   
  }
  echo "<td><strong>".(($saldo>0) ? '+'.$saldo : $saldo)."</strong></td>";
  echo "</tr>";
}

?>
</tbody>
</table>

<br/>
<h5 class="subsection">I <?php echo ($ramo==1?'deputati':'senatori')?> che hanno cambiato gruppo</h5>
Dall'inizio della legislatura ad oggi, <strong><?php echo count($parlamentari_change) ?> <?php echo ($ramo==1?'deputati':'senatori')?></strong> hanno cambiato gruppo di appartenenza <?php echo ($ramo==1?'alla Camera':'al Senato')?>.
<br/><br/>
<table class="disegni-decreti column-table lazyload">
  <thead>
    <tr>
      <th scope="col"><?php echo ($ramo==1?'Deputato':'Senatore')?></th>
      <th scope="col">Numero di<br/>passaggi</th>
      <th scope="col">Passaggi di gruppo</th>
    </tr>
  </thead>
  <tbody>

<?php 

if (count($parlamentari_change)>0)
{
  foreach ($parlamentari_change as $p)
  {
    echo "<tr>";
    echo"<th scope='row'>". link_to(OppCaricaPeer::retrieveByPk($p)->getOppPolitico()->getCognome(). " ".OppCaricaPeer::retrieveByPk($p)->getOppPolitico()->getNome(),'@parlamentare?id='.OppCaricaPeer::retrieveByPk($p)->getOppPolitico()->getId())."</th>";
    $res=OppCaricaHasGruppoPeer::doSelectTuttiGruppiPerCarica($p,1);
    echo "<td>".(count($res)-1)."</td>";
    echo "<td>";
    foreach ($res as $k => $rs)
    {
      
      if (substr_count($rs['data_fine'],"-")>0)
        $date_check=true;
      else
        $date_check=false;
      echo OppGruppoPeer::retrieveByPk($rs['gruppo_id'])->getAcronimo().($date_check==true ? " ==> ":"");
    }
    echo "<td>";
    echo "</tr>";
  }
}
?>
  </tbody>
</table>

