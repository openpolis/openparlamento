<ul class="float-container tools-container" id="content-tabs">
  <li class="current"><h2>Classifica <?php echo $tipo_politici=='dep'?'deputati':'senatori' ?> per pool di argomenti ActionAid</h2></li>
</ul>

<div class="tabbed float-container" id="content">
	<div id="main">

    <div class="W25_100 float-right">
      Il pool di argomenti considerato:
      <ul>
        <?php foreach ($argomentis as $name => $id): ?>
          <li><?php echo link_to($name, '@argomento_sioccupanodi?triple_value='.$name.'&ramo='.$ramo) ?></li>
        <?php endforeach ?>
      </ul>
    </div>
    
	  <div class="W73_100 float-left">

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
  </div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  <?php echo link_to('argomenti', '@argomenti') ?> /
  classifica ActionAid
<?php end_slot() ?>
