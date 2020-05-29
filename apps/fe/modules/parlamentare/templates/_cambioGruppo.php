<div class="section-box"> 
            <h3 class="section-box-no-rss">Ultimi cambi di gruppo in Parlamento</span></h3> 
</div>
 
<table class="disegni-decreti column-table v-align-middle"> 
<tbody>	
<?php $tr_class = 'even' ?>	
<?php $i=0 ?>			  
<?php while($parlamentari->next()) : ?>
  <?php if ($parlamentari->getString(5)!=$parlamentari->getString(7) && $i<$limit) : ?>
    <?php $i++ ?>
    <tr class="<?php echo $tr_class; ?>">
    <?php $tr_class = ($tr_class == 'even' ? 'odd' : 'even' )  ?> 
    <th scope="row">
      <p class="politician-id">
      <?php echo image_tag(OppPoliticoPeer::getThumbUrl($parlamentari->getInt(1)), 
                        array('width' => '40','height' => '53' )) ?>	
      <?php 
      use_helper('Slugger');
      $slugParlamentare = slugify($parlamentari->getString(2).' '.$parlamentari->getString(3));
      echo ($parlamentari->getInt(6)==1?'On. ':'Sen. '). link_to($parlamentari->getString(2).' '.$parlamentari->getString(3), '@parlamentare?id='.$parlamentari->getInt(1).'&slug='.$slugParlamentare) ?>
      </p>
      </th>
      <td>
      <span class="small">il <?php echo date('d/m/Y',strtotime($parlamentari->getString(5))) ?> ha aderito al gruppo</span><br/><strong><?php echo $parlamentari->getString(4)?></strong>
      <?php $gruppo= OppCaricaHasGruppoPeer::getGruppoPerParlamentareAllaData($parlamentari->getInt(8),date('Y-m-d',strtotime($parlamentari->getString(5)) -1)) ?>
      <?php if (count($gruppo)==1) : ?>
        <br/><span class="small"> abbandonando il gruppo</span><br/><?php echo OppGruppoPeer::retrieveByPk($gruppo['gruppo_id'])->getNome()?>
      <?php endif; ?>
      </td>              
    </tr>
  <?php endif ?>  
<?php endwhile; ?>
<tr>
  <td>&nbsp;</td>
    <td><?php echo link_to('gruppi alla camera','@gruppi_camera').' | '.link_to('gruppi al senato','@gruppi_senato') ?></td>
</tr>    
</tbody>
</table>
