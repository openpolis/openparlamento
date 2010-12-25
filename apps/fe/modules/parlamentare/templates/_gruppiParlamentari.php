<br/>

<h5 class="subsection">La composizione dei gruppi parlamentari <?php echo ($ramo==1?'della Camera':'del Senato')?> e variazioni nel corso della legislatura</h5>
<div class="W73_100 float-left" style="width:55%">
  
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
$saldo_magg=0;
$num_magg=0;
$saldo_min=0;
$num_min=0;
$saldo_neutral=0;
$num_neutral=0;
$tr_class = 'even';
foreach ($gruppo_now as $k => $g)
{
  if ($g!==0)
  {
    $valore=OppGruppoIsMaggioranzaPeer::isGruppoMaggioranza($k,date('Y-m-d'));
    echo "<tr class='".$tr_class."'>";
    $tr_class = ($tr_class == 'even' ? 'odd' : 'even' );
    if ($valore===null)
      $color_gruppo="#a29c9c"; 
    elseif ($valore==0)
      $color_gruppo="#766d04";
    elseif ($valore==1)
    $color_gruppo="#022468";
       
    echo "<th scope='row'><span style='background-color:".$color_gruppo."; color:white; margin:5px;'>&nbsp;</span>".link_to(OppGruppoPeer::retrieveByPk($k)->getNome(),'@parlamentari?ramo='.($ramo==1?'camera':'senato').'&sort=nome&type=asc&filter_group='.$k)."</th>";
    echo "<td>".link_to($g,'@parlamentari?ramo='.($ramo==1?'camera':'senato').'&sort=nome&type=asc&filter_group='.$k)."</td>";
    echo "<td>".$gruppo_in[$k]."</td>";
    echo "<td>".$gruppo_out[$k]."</td>";
    echo "<td><strong>".(($gruppo_in[$k]-$gruppo_out[$k])>0 ? '+'.($gruppo_in[$k]-$gruppo_out[$k]) : ($gruppo_in[$k]-$gruppo_out[$k]))."</strong></td>";
    
    if ($valore===null)
    {
      $saldo_neutral=$saldo_neutral+$gruppo_in[$k]-$gruppo_out[$k];
      $num_neutral=$num_neutral+$g;
    }
    elseif ($valore==1)
    {
      $saldo_magg=$saldo_magg+$gruppo_in[$k]-$gruppo_out[$k];
      $num_magg=$num_magg+$g;
    }
    elseif ($valore==0)
    {
       $saldo_min=$saldo_min+$gruppo_in[$k]-$gruppo_out[$k];
       $num_min=$num_min+$g;
    }
    echo "</tr>";
   
   if ($valore===null)
      $perc_neutral[$k]=$g;
   elseif ($valore==1)
      $perc_magg[$k]=$g;
   elseif ($valore==0)
      $perc_min[$k]=$g;
  }
  
}
$perc_grafico="50,";
$label_grafico="|";
$color_grafico="FFFFFF|";
foreach($perc_magg as $k => $perc)
{
  if ($ramo==1)
    $perc_grafico=$perc_grafico.(number_format($perc*100/630/2,2)).",";
  else
    $perc_grafico=$perc_grafico.(number_format($perc*100/321/2,2)).",";
  $label_grafico=$label_grafico.OppGruppoPeer::retrieveByPk($k)->getAcronimo()." [".$perc."]|";
}

foreach($perc_neutral as $k => $perc)
{
  if ($ramo==1)
    $perc_grafico=$perc_grafico.(number_format($perc*100/630/2,2)).",";
  else
    $perc_grafico=$perc_grafico.(number_format($perc*100/321/2,2)).",";
  $label_grafico=$label_grafico.OppGruppoPeer::retrieveByPk($k)->getAcronimo()." [".$perc."]|"; 
}

foreach($perc_min as $k => $perc)
{
  if ($ramo==1)
    $perc_grafico=$perc_grafico.(number_format($perc*100/630/2,2)).",";
  else
    $perc_grafico=$perc_grafico.(number_format($perc*100/321/2,2)).",";
  $label_grafico=$label_grafico.OppGruppoPeer::retrieveByPk($k)->getAcronimo()." [".$perc."]|"; 
}


for ($x=0;$x<count($perc_magg);$x++)
{
  switch ($x) {
      case 0:
          $color_grafico=$color_grafico."022468|";
          break;
      case 1:
          $color_grafico=$color_grafico."063cab|";
          break;
      case 2:
          $color_grafico=$color_grafico."0b50dc|";
          break;
      case 3:
          $color_grafico=$color_grafico."105dfb|";
          break;    
      case 4:
          $color_grafico=$color_grafico."3c7af9|";
          break;
      case 5:
          $color_grafico=$color_grafico."6f9df9|";
          break;    
  }

}

for ($x=0;$x<count($perc_neutral);$x++)
{
  switch ($x) {
      case 0:
          $color_grafico=$color_grafico."a29c9c|";
          break;
      case 1:
          $color_grafico=$color_grafico."938f8f|";
          break;
      case 2:
          $color_grafico=$color_grafico."8a8585|";
          break;
      case 3:
          $color_grafico=$color_grafico."837e7e|";
          break;    
      case 4:
          $color_grafico=$color_grafico."767373|";
          break;
      case 5:
          $color_grafico=$color_grafico."636060|";
          break;    
  }

}


for ($x=0;$x<count($perc_min);$x++)
{
  switch ($x) {
      case 0:
          $color_grafico=$color_grafico."766d04|";
          break;
      case 1:
          $color_grafico=$color_grafico."ac9f09|";
          break;
      case 2:
          $color_grafico=$color_grafico."e1cf0a|";
          break;
      case 3:
          $color_grafico=$color_grafico."f9e50b|";
          break;    
      case 4:
          $color_grafico=$color_grafico."f8e72b|";
          break;
      case 5:
          $color_grafico=$color_grafico."f9ee70|";
          break;    
  }

}

?>

 </tbody>
</table> 
<br/>
<div><span style="background-color:#022468; color:white; padding: 3px; margin-right:10px; font-size:10px;">maggioranza</span><span style="background-color:#766d04; color:white; padding: 3px; margin-right:10px; font-size:10px">opposizione</span></div>
</div>
<div class="W73_100 float-right" style="width:40%;">
  <img src="http://chart.apis.google.com/chart?cht=p&chd=t:<?php echo rtrim($perc_grafico,',') ?>&chs=400x240&chl=<?php echo rtrim($label_grafico, '|') ?>&chco=<?php echo rtrim($color_grafico,'|') ?>">
</div>  
<br/>
<div class="W73_100 float-left" style="width:55%">
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
  $valore=OppGruppoIsMaggioranzaPeer::isGruppoMaggioranza($k,date('Y-m-d'));
  echo "<tr class='".$tr_class."'>";
  $tr_class = ($tr_class == 'even' ? 'odd' : 'even' );
  if ($valore===null)
    $color_gruppo="#a29c9c"; 
  elseif ($valore==0)
    $color_gruppo="#766d04";
  elseif ($valore==1)
    $color_gruppo="#022468";
    
  echo "<th scope='row' style='font-size:11px;'><span style='background-color:".$color_gruppo."; color:white; margin:5px;'>&nbsp;</span><strong>".OppGruppoPeer::retrieveByPk($k)->getAcronimo()."</strong></td>";
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
<div><span style="background-color:#022468; color:white; padding: 3px; margin-right:10px; font-size:10px;">maggioranza</span><span style="background-color:#766d04; color:white; padding: 3px; margin-right:10px; font-size:10px">opposizione</span></div>

<br/>
</div>
<div class="W73_100 float-right" style="width:40%">
  <h5 class="subsection">Maggioranza VS Opposizione: chi guadagna e chi perde</h5>
  <br/>
<table class="disegni-decreti column-table lazyload">
  <thead>
    <tr>
      <th scope="col"></th>
      <th scope="col">Membri<br/>attuali:</th> 	
      <th scope="col">Membri<br/>iniziali:</th>
      <th scope="col">Saldo:</th>
    </tr>
  </thead>
  <tbody>
    <tr class='even'>
      <th scope='row'><span style='background-color:#022468;margin:5px;'>&nbsp;</span>Maggioranza</th>
      <td><?php echo $num_magg ?></td>
      <td><?php echo $num_magg-$saldo_magg ?></td>
      <td><strong><?php echo ($saldo_magg>0 ? "+".$saldo_magg : $saldo_magg ) ?></strong></td>
    </tr>
    <tr class='odd'>
      <th scope='row'><span style='background-color:#766d04;margin:5px;'>&nbsp;</span>Opposizione</th>
      <td><?php echo $num_min ?></td>
      <td><?php echo $num_min-$saldo_min ?></td>
      <td><strong><?php echo ($saldo_min>0 ? "+".$saldo_min : $saldo_min ) ?></strong></td>
    </tr>
  </tbody>
</table>      
<br/>
<?php $margine_maggioranza=$num_magg-($ramo==1 ? '316' : '161') ?>
Per la maggioranza in questo ramo del Parlamento sono necessari <?php echo ($ramo==1 ? '<strong>316</strong> deputati' : '<strong>161</strong> senatori')?>.<br/>
Oggi il Governo ha il sostegno di <strong><?php echo $num_magg ?></strong> <?php echo ($ramo==1 ? 'deputati' : 'senatori')?> <strong>appartenenti ai gruppi di maggioranza</strong>.<br/>
<?php echo ($margine_maggioranza>0 ?'Possiede quindi un margine di <strong>'.$margine_maggioranza.'</strong> parlamentari.' :'Ha bisogno quindi del sostegno di<strong>'.$margine_maggioranza.'</strong> parlamentari di altri gruppi.') ?> 

</div>
<div class="W73_100 float-left" style="width:60%">
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
      echo OppGruppoPeer::retrieveByPk($rs['gruppo_id'])->getAcronimo().($date_check==true ? image_tag('rightArrow.png', array('style' => 'width:18px; vertical-align: text-bottom; padding: 0 3px 0 3px')) : "");
    }
    echo "<td>";
    echo "</tr>";
  }
}
?>
  </tbody>
</table>
</div>

