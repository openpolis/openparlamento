<strong>Progetti che sono diventati Legge</strong>
<br /><br />
<?php foreach ($arrs as $i=>$arr ) : ?>
  <?php if ($i==0): ?>
    <?php echo "Parlamentare - " ?>
  <?php endif ?>  
  <?php if ($i==1): ?>
    <?php echo "Governo - " ?>
  <?php endif ?>
  <?php if ($i==2): ?>
    <?php echo "Popolo - " ?>
  <?php endif ?>
  <?php echo "Presentati: ".$arr[0]." - Leggi: ".$arr[1]." - % di successo: ".number_format($arr[1]*100/$arr[0],2)." - tempo medio: ".$arr[2]." giorni" ?>
  <?php echo "<br/>" ?>
<?php endforeach ?>
<br /><br />
<strong>Le leggi più veloci</strong>
<br /><br />
<?php $veloci=array_slice($arr_alls, 0, 20) ?>
<?php foreach ($veloci as $veloce ) : ?>
  <?php echo "- ". link_to($veloce[0]->getRamo().".".$veloce[0]->getNumfase(),"/singolo_atto/".$veloce[0]->getId())." - ".$veloce[0]->getTitolo()." - Giorni: ".intval($veloce[1]) ?>
  <?php echo "<br/>" ?>
<?php endforeach ?> 
<br /><br />
<strong>Le leggi più lente</strong>
<br /><br />
<?php $lenti=array_slice($arr_alls, count($arr_alls)-20, 20) ?>
<?php $lenti=array_reverse($lenti) ?>
<?php foreach ($lenti as $lenta ) : ?>
  <?php echo "- ". link_to($lenta[0]->getRamo().".".$lenta[0]->getNumfase(),"/singolo_atto/".$lenta[0]->getId())." - ".$lenta[0]->getTitolo()." - Giorni: ".intval($lenta[1]) ?>
  <?php echo "<br/>" ?>
<?php endforeach ?> 


