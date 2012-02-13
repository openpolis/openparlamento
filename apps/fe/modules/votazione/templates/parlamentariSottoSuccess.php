<?php use_helper('I18N', 'Date', 'Slugger') ?>

<?php include_partial('tabs', array('current' => 'maggioranza_sotto')) ?>

<div class="row">
	<div class="twelvecol">
		
		<?php echo include_partial('secondLevelVotiMaggioranzaSotto', 
	                               array('current' => $ramo)); ?>

	    <p style="font-size:16px;width:90%;margin-bottom:10px;">L'elenco mostra le volte in cui i <strong><?php echo ($ramo=='camera'?'deputati':'senatori')?> della maggioranza</strong> con le loro assenze o voti differenti dal proprio gruppo di appartenenza, sono stati determinanti per la sconfitta nelle votazioni della maggioranza di Governo.<br/>
	      Il calcolo tiene conto delle variazioni delle maggioranze parlamentari e delle diverse appartenenze dei <?php echo ($ramo=='camera'?'deputati':'senatori')?> ai gruppi nel corso della legislatura.<br/>
	      La lista è ordinata per "totale votazioni", per altri ordinamenti, in maniera crescente o decrescente, fai click sul titolo della colonna corrispondente. 
	      <?php include_partial('wikiMaggioranzaSotto') ?> 
	    </p>

	    <table class="chart tablesorter" id="complete-chart" style="width:98%;">
	      <thead>
	        <tr>
	          <th style="vertical-align:middle;"><?php echo ($ramo=='camera'?'deputato':'senatore')?>:</th>
	          <th style="vertical-align:middle;">circoscrizione:</th>
	          <th style="vertical-align:middle;">totale votazioni:</th> 
	          <th style="vertical-align:middle;">voti espressi determinanti:</th>
	          <th style="vertical-align:middle;">assenze determinanti:</th>	
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

	                <?php 
	                $slugPolitico = slugify($parlamentari->getString(3).' '.$parlamentari->getString(4));
	                echo link_to($parlamentari->getString(3).' '.$parlamentari->getString(4), '@parlamentare?id='.$parlamentari->getInt(2).'&slug='.$slugPolitico) ?>
	                (
	                <?php if (OppCaricaHasGruppoPeer::getGruppoCorrentePerCarica($parlamentari->getInt(1))) : ?>
	                  <?php echo OppCaricaHasGruppoPeer::getGruppoCorrentePerCarica($parlamentari->getInt(1))->getAcronimo() ?>
	                <?php endif; ?>
	                <?php $gruppi = OppCaricaHasGruppoPeer::doSelectTuttiGruppiPerCarica($parlamentari->getInt(1)) ?>
	                <?php if (count($gruppi)>1 || !OppCaricaHasGruppoPeer::getGruppoCorrentePerCarica($parlamentari->getInt(1))) : ?>
	                  <span style="font-size:10px">
	                    <?php if ($parlamentari->getString(9)!=NULL) :?>
	                      <?php echo "<span style='background-color:yellow;'>in carica fino al ".format_date($parlamentari->getString(9),'dd/MM/yyyy')."</span>" ?>
	                    <?php endif; ?>
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
	            <td><?php echo $parlamentari->getString(8) ?></td>
	            <?php if ($parlamentari->getString(9)==NULL) :?>
	              <td><strong><?php echo link_to($parlamentari->getInt(5), 
	  				                     '@parlamentare_voti?id='.$parlamentari->getInt(2).'&slug='.$slugPolitico.'&filter_vote_rebel=2') ?></strong></td>
	              <td><strong><?php echo link_to($parlamentari->getInt(5)-$parlamentari->getInt(7),'@parlamentare_voti?id='.$parlamentari->getInt(2).'&slug='.$slugPolitico.'&filter_vote_rebel=2&filter_vote_vote=Presente') ?></strong></td>            
	              <td><strong><?php echo link_to($parlamentari->getInt(7), 
	                       				'@parlamentare_voti?id='.$parlamentari->getInt(2).'&slug='.$slugPolitico.'&filter_vote_rebel=2&filter_vote_vote=Assente') ?></strong></td>
	            <?php else : ?>
	              <td><strong><?php echo $parlamentari->getInt(5) ?></strong></td>
	              <td><strong><?php echo $parlamentari->getInt(5)-$parlamentari->getInt(7) ?></strong></td>            
	              <td><strong><?php echo $parlamentari->getInt(7) ?></strong></td>
	            <?php endif; ?>            				

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