<?php use_helper('I18N', 'Date') ?>

<?php include_partial('tabs', array('current' => 'maggioranza_sotto')) ?>
<div id="content" class="tabbed float-container">
  <div id="main">
    <?php echo include_partial('secondLevelVotiMaggioranzaSotto', 
                               array('current' => $ramo)); ?>
                               
    <p style="font-size:16px;width:70%;margin-bottom:10px;">L'elenco mostra nell'ordine le volte in cui i <strong><?php echo ($ramo=='camera'?'deputati':'senatori')?> della maggioranza</strong> con le loro assenze o voti differenti dal proprio gruppo di appartenenza, sono stati determinanti per la sconfitta nelle votazioni della maggioranza parlamentare.<br/>
      Il calcolo tiene conto dei cambiamenti delle maggioranze parlamentari e delle diverse appartenenze ai gruppi nel corso della legislatura.
    </p>
    
    <table class="chart tablesorter" id="complete-chart" style="width:90%;">
      <thead>
        <tr>
          <th style="vertical-align:middle;"><?php echo ($ramo=='camera'?'deputato':'senatore')?>:</th>
          <th style="vertical-align:middle;">voti espressi determinanti:</th>
          <th style="vertical-align:middle;">assenze determinanti:</th>
          <th style="vertical-align:middle;">totale votazioni:</th> 	
        </tr>
      </thead>

      <tbody>

        <?php $tr_class = 'even' ?>				  
        <?php while($parlamentari->next()): ?>
          <?php if($parlamentari->getInt(5)>0) : ?>
          <tr class="<?php echo $tr_class; ?>">
          <?php $tr_class = ($tr_class == 'even' ? 'odd' : 'even' )  ?>
            <td style="text-align:left;">
              <p class="politician-id">
                
                <?php echo link_to($parlamentari->getString(3).' '.$parlamentari->getString(4), '@parlamentare?id='.$parlamentari->getInt(2)) ?>
                <?php echo " (".OppCaricaHasGruppoPeer::getGruppoCorrentePerCarica($parlamentari->getInt(1))->getAcronimo() ?>
                <?php $gruppi = OppCaricaHasGruppoPeer::doSelectTuttiGruppiPerCarica($parlamentari->getInt(1)) ?>
                <?php if (count($gruppi)>1) : ?>
                  <span style="font-size:10px">
                  <?php foreach ($gruppi as $g) : ?>
                    <?php if ($g['data_fine']!=null) : ?>
                      <?php $gruppo=OppGruppoPeer::retrieveByPk($g['gruppo_id']) ?>
                      <?php echo ", ".$gruppo->getAcronimo()." dal ".format_date($g['data_inizio'],'dd/MM/yyyy')." al ".format_date($g['data_fine'],'dd/MM/yyyy') ?>
                    <?php endif ?>
                  <?php endforeach ?>
                  </span>
                <?php endif ?>
                )
              </p>
            </td>
            <td><?php echo link_to($parlamentari->getInt(5)-$parlamentari->getInt(7),'@parlamentare_voti?id='.$parlamentari->getInt(2).'&filter_vote_rebel=2&filter_vote_vote=Presente') ?></td>            
            <td><?php echo link_to($parlamentari->getInt(7), 
                       				'@parlamentare_voti?id='.$parlamentari->getInt(2).'&filter_vote_rebel=2&filter_vote_vote=Assente') ?></td>
           
            <td><?php echo link_to($parlamentari->getInt(5), 
  				                     '@parlamentare_voti?id='.$parlamentari->getInt(2).'&filter_vote_rebel=2') ?></td>
  				        				                         
          </tr>
          <?php else : ?>
            <?php break;?>
          <?php endif; ?>  
        <?php endwhile; ?>
      </tbody>    
    </table>
  </div>
</div>    

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  <?php echo ($ramo=='camera'?'I deputati ':'I senatori ')?>che fanno cadere la maggioranza
<?php end_slot() ?>

<script type="text/javascript" charset="utf-8">
   $(document).ready(function() { 
     $("#complete-chart").tablesorter({
       sortList: [[2, 1]], 
       widgets: ['zebra']
     }); 
   });  
 </script>