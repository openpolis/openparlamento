 <h3 class="subsection" id="#<?php echo $sede_id ?>" style="float:left; width:95%; font-size: 16px;">
   <a href="#<?php echo $sede_id ?>" name="<?php echo $sede_id ?>"><?php echo OppSedePeer::retrieveByPk($sede_id)->getDenominazione() ?></a>
 </h3>

<div class="clearfix">
    <div class="W73_100 float-left" style="width:40%">
          <table class="disegni-decreti column-table lazyload">
            <thead>
              <tr>
                <th scope="col">Gruppo:</th>
                <th scope="col">Presidente:</th> 	
                <th scope="col">Vicepresidenti:</th>
                <?php echo (OppSedePeer::retrieveByPk($sede_id)->getTipologia()=='Presidenza' ?'<th scope="col">Questori:</th>' :'') ?>
                <th scope="col">Segretari:</th>
                <?php echo (OppSedePeer::retrieveByPk($sede_id)->getTipologia()=='Presidenza' ?'' :'<th scope="col">Membri:</th>') ?>
                <th scope="col">Totale:</th>
              </tr>
            </thead>

            <tbody>
        <?php $tr_class = 'even'; ?>
        <?php foreach ($gruppi_all as $k => $gruppo) : ?>
          <tr class="<?php echo ($tr_class == 'even' ? 'odd' : 'even' ); ?>">
          <?php $tr_class = ($tr_class == 'even' ? 'odd' : 'even' )  ?>
  
          <?php $valore=OppGruppoIsMaggioranzaPeer::isGruppoMaggioranza($k,date('Y-m-d')); ?>
           <?php if ($valore===null) : ?>
             <?php $color_gruppo="#f094f3"; ?>
           <?php elseif($valore==1) : ?>   
             <?php $color_gruppo="#022468"; ?>
           <?php elseif($valore==0) : ?>
             <?php $color_gruppo="#766d04"; ?>
            <?php endif; ?>
     
          <th scope='row'><span style='background-color:<?php echo $color_gruppo ?>; color:white; margin:5px;'>&nbsp;</span><?php echo OppGruppoPeer::retrieveByPk($k)->getAcronimo(); ?></th>
          <td>
            <?php if (array_key_exists($k,$gruppi_p)) : ?>
              <span style="font-weight:bold; background-color:yellow; padding:3px;"><?php echo $gruppi_p[$k]; ?></span>
            <?php else : ?>  
              <?php echo "0"; ?>
            <?php endif; ?>
          </td>
          <td>
            <?php if (array_key_exists($k,$gruppi_vp)) : ?>
              <?php echo $gruppi_vp[$k]; ?>
            <?php else :?>  
              <?php echo "0"; ?>
            <?php endif; ?>
          </td>
          <?php if(OppSedePeer::retrieveByPk($sede_id)->getTipologia()=='Presidenza') :?>
            <td>
              <?php if (array_key_exists($k,$gruppi_q)) : ?>
                <?php echo $gruppi_q[$k]; ?>
              <?php else :?>  
                <?php echo "0"; ?>
              <?php endif; ?>
            </td>
          <?php endif; ?>  
    
          <td>
            <?php if (array_key_exists($k,$gruppi_s)) : ?>
              <?php echo $gruppi_s[$k]; ?>
            <?php else :?>  
              <?php echo "0"; ?>
            <?php endif; ?>
          </td>
          <?php if(OppSedePeer::retrieveByPk($sede_id)->getTipologia()!='Presidenza') :?>
          <td>
            <?php if (array_key_exists($k,$gruppi_c)) : ?>
              <?php echo $gruppi_c[$k]; ?>
            <?php else :?>  
              <?php echo "0"; ?>
            <?php endif; ?>
          </td>
          <?php endif; ?>
          <td class="evident">
              <strong><?php echo $gruppo ?></strong>
          </td>
         </tr>
   
        <?php endforeach; ?>  
        <tr>
           <th scope='row'>Totali</th>
           <td><?php echo array_sum($gruppi_p)?></td>
           <td><?php echo array_sum($gruppi_vp)?></td>
           <?php if(OppSedePeer::retrieveByPk($sede_id)->getTipologia()=='Presidenza') :?>
              <td><?php echo array_sum($gruppi_q)?></td>
           <?php endif; ?>    
           <td><?php echo array_sum($gruppi_s)?></td>
            <?php if(OppSedePeer::retrieveByPk($sede_id)->getTipologia()!='Presidenza') :?>
              <td><?php echo array_sum($gruppi_c)?></td>
            <?php endif; ?>  
           <td class="evident"><strong><?php echo array_sum($gruppi_all)?></strong></td>
          </tr>
        </tbody>
        </table>
        <br/>
        <div><span style="background-color:#022468; color:white; padding: 3px; margin-right:10px; font-size:10px;">maggioranza</span><span style="background-color:#766d04; color:white; padding: 3px; margin-right:10px; font-size:10px">opposizione</span></div>
        <br/>

    </div>
    <div class="W73_100 float-right" style="width:56%;">
        <?php  
           $perc_magg=array();
           $perc_min=array();
           $perc_neutral=array();
           $num_totale=0;
           foreach ($gruppi_all as $k => $gruppo)
           {
             $valore=OppGruppoIsMaggioranzaPeer::isGruppoMaggioranza($k,date('Y-m-d'));
             if ($valore===null)
              $perc_neutral[$k]=$gruppo;
             elseif($valore==1)
              $perc_magg[$k]=$gruppo;
             elseif($valore==0) 
              $perc_min[$k]=$gruppo;

             $num_totale=$num_totale+$gruppo;  
           }
           // Conteggi per maggioranza di Governo in commissione
           /*
           echo "<div style='padding-bottom:7px;'>";
           $necessari=intval($num_totale/2)+1;
           if (array_sum($perc_magg)>=$necessari)
           {
             echo "<p style='font-size:16px; margin-bottom:5px;'>Il Governo ";
             if ((array_sum($perc_magg)-$necessari)==0)
               echo '<strong>ha la stretta maggioranza necessaria</strong> in questo organo.';
             elseif((array_sum($perc_magg)-$necessari)==1)
              echo 'ha un margine di <strong>un parlamentare</strong>  in questo organo.';
             else
              echo 'ha un margine di <strong>'.(array_sum($perc_magg)-$necessari).' parlamentari</strong> in questo organo.';
    
             echo '</p>';
           }
     
           else
           {
             echo "<p style='font-size:16px; margin-bottom:5px;'><span style='background-color:yellow; padding:3px;'>Il Governo ha bisogno del sostegno di <strong>";
              if(abs(array_sum($perc_magg)-$necessari)==1)
                echo 'un parlamentare di un altro gruppo</strong>.</span></p>';
              else 
                echo abs(array_sum($perc_magg)-$necessari).' parlamentari di altri gruppi</strong>.</span></p>';
           }
    
     
           echo "Per la maggioranza in questo organo sono necessari ".$necessari." parlamentari.<br/>";
           echo "Oggi il Governo ha il sostegno di <strong>". array_sum($perc_magg)."</strong> parlamentari <strong>appartenenti ai gruppi di maggioranza</strong>.<br/>";
           echo "<span style='font-size:10px; color:gray;'>N.B.: nessun componente del gruppo misto &egrave; conteggiato come appartenente alla maggioranza di Governo.</span<br/>";
           echo "</div>";
           */
   
          $perc_grafico="50,";
          $label_grafico="|";
          $color_grafico="FFFFFF|";
          foreach($perc_magg as $k => $perc)
          {
            $perc_grafico=$perc_grafico.(number_format($perc*100/$num_totale/2,2)).",";
            $label_grafico=$label_grafico.OppGruppoPeer::retrieveByPk($k)->getAcronimo()." [".$perc."]|";
          }
          foreach($perc_neutral as $k => $perc)
          {
            $perc_grafico=$perc_grafico.(number_format($perc*100/$num_totale/2,2)).",";
            $label_grafico=$label_grafico.OppGruppoPeer::retrieveByPk($k)->getAcronimo()." [".$perc."]|"; 
          }
          foreach($perc_min as $k => $perc)
          {
            $perc_grafico=$perc_grafico.(number_format($perc*100/$num_totale/2,2)).",";
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
                     $color_grafico=$color_grafico."f094f3|";
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
  
 
          $chld="";
           $color="";
           $z=0;
          arsort($membri_regione);
          foreach ($membri_regione as $k => $m)
          {
            $chld=$chld."IT-".$k."|";

              if ($m>=10)
                 $color=$color."ff0000|";
               elseif ($m<10 && $m>=8)  
                 $color=$color."ff3200|";
               elseif ($m<8 && $m>=6)  
                   $color=$color."ff4a00|";
               elseif ($m<6 && $m>=5)  
                   $color=$color."ff6100|"; 
               elseif ($m==4)  
                   $color=$color."ff7d00|"; 
              elseif ($m==3)  
                  $color=$color."ff9600|";     
              elseif ($m==2)  
                   $color=$color."ffba00|";
              elseif ($m==1)  
                   $color=$color."ffb500|";     
              elseif ($m==0)  
                   $color=$color."a0a0a0|";               
      
            $z++;
          }
  
          $color="FFFFFF|".$color;
  
        ?>  
        <div style="padding:5px">
         L'insieme dei componenti divisi per incarichi e gruppi parlamentari.<br/>
         La cartina dell'Italia mostra, a seconda dei colori (rosso molti, grigio nessuno), il numero di componenti suddivisi per circoscrizione elettorale. 
         </div>
        <img src="http://chart.apis.google.com/chart?cht=p&chd=t:<?php echo rtrim($perc_grafico,',') ?>&chs=380x240&chl=<?php echo rtrim($label_grafico, '|') ?>&chco=<?php echo rtrim($color_grafico,'|') ?>">

        <img src="http://chart.apis.google.com/chart?cht=map&chs=200x300&chld=<?php echo trim($chld,"|") ?>&chco=<?php echo trim($color,"|") ?>">
    </div>
</div>     
    <div>
      <ul style="list-style-type:none;">
          <li id="sede-<?php echo $sede_id ?>" style="padding-bottom:5px;">
          <span style="font-size:16px;">Componenti ordinati per incarico [<?php echo link_to('mostra',
                              '@commissioni_membri?sede='.$sede_id.'&sort=carica',
                              array('class' => 'show-hide-dettaglio')) ?>]</span>
          </li>
          <li id="sede-<?php echo $sede_id ?>" style="padding-bottom:5px;">
            <span style="font-size:16px;">Componenti ordinati per gruppo 
          [<?php echo link_to('mostra',
                              '@commissioni_membri?sede='.$sede_id.'&sort=gruppo',
                              array('class' => 'show-hide-dettaglio')) ?>]</span>
          </li>
          <?php if (count(OppAttoPeer::getAttiPerCommissioneLastIter($sede_id,'approvato definitivamente',$leg))>0) : ?>
            <li id="sede-<?php echo $sede_id ?>" style="padding-bottom:5px;">
              <span style="font-size:16px;">Leggi approvate discusse in sede referente: <strong><?php echo count(OppAttoPeer::getAttiPerCommissioneLastIter($sede_id,'approvato definitivamente',$leg)) ?></strong> [<?php echo link_to('mostra',
                              '@disegno_commissione?sede='.$sede_id.'&stato=approvato definitivamente',
                              array('class' => 'show-hide-dettaglio')) ?>]</span>
          <?php endif ?>                    
          </li>
          <?php if (count(OppAttoPeer::getAttiPerCommissioneLastIter($sede_id,'in corso di esame in commissione',$leg))>0) : ?>
            <li id="sede-<?php echo $sede_id ?>" style="padding-bottom:5px;">
              <span style="font-size:16px;">Disegni di legge attualmente in discussione in sede referente: <strong><?php echo count(OppAttoPeer::getAttiPerCommissioneLastIter($sede_id,'in corso di esame in commissione',$leg)) ?></strong> [<?php echo link_to('mostra',
                              '@disegno_commissione?sede='.$sede_id,
                              array('class' => 'show-hide-dettaglio')) ?>]</span>
          <?php endif ?>                    
          </li>
          </ul>
    </div> 
