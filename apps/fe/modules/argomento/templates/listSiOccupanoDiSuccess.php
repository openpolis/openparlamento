<ul class="float-container tools-container" id="content-tabs">
  <li class="current"><h2>Argomento: <?php echo strtolower($argomento) ?></h2></li>
</ul>

<div class="row">
	<div class="ninecol">
		
		<?php echo include_partial('secondlevelmenu', 
	                               array('current' => $tipo_politici.'_sioccupano', 
	                                     'triple_value' => $argomento_tv)); ?>

      <?php if (count($politici) > 0): ?>
        <div class="pad10">
   
        	<ul>
        	  <?php $cnt = 0; foreach ($politici as $carica_id => $politico): ?>
        	     <li style="font-size:12px; padding:5px 0 0 0;">
        	       <?php echo ++$cnt ?>)
        	       <?php echo link_to($politico['nome'] . " " . $politico['cognome'] . " (".$politico['acronimo'].")", '@parlamentare?id='.$politico['politico_id'], array('class' => 'folk2', 'title' => $politico['punteggio'])); ?> (<?php echo $politico['punteggio'] ?>)
        	     </li>
        	  <?php endforeach ?>
          </ul>
    
        </div>
      <?php endif ?>
		
		
	</div>
	<div class="threecol last"></div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  <?php echo link_to('argomenti', '@argomenti') ?> /
  <?php echo link_to(strtolower($argomento), '@argomento?triple_value='.$argomento->getTripleValue()) ?>
<?php end_slot() ?>
