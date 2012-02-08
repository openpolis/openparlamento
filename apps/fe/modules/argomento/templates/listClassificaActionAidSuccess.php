<?php if ($sf_user->hasCredential('amministratore') || $sf_user=='actionaid') : ?>

<div class="row" id="tabs-container">
    <ul class="float-container tools-container" id="content-tabs">
      <li class="current"><h2>Classifica <?php echo $tipo_politici=='dep'?'deputati':'senatori' ?> per pool di argomenti ActionAid</h2></li>
    </ul>
</div>


	<div class="row">
		
		<div class="ninecol">
	      <?php if (count($politici) > 0): ?>
	        Chi si occupa maggiormente degli argomenti selezionati
	        <div class="pad10">

	        	<ul>
	        	  <?php $cnt = 0; use_helper('Slugger'); foreach ($politici as $carica_id => $politico): ?>
	        	     <li style="font-size:12px; padding:5px 0 0 0;">
	        	       <?php echo ++$cnt ?>)
	        	       <?php echo link_to($politico['nome'] . " " . $politico['cognome'] . " (".$politico['acronimo'].")", '@parlamentare?id='.$politico['politico_id'] .'&slug='. slugify($politico['nome'] . " " . $politico['cognome']), array('class' => 'folk2', 'title' => $politico['punteggio'])); ?> (<?php echo $politico['punteggio'] ?>)
	        	     </li>
	        	  <?php endforeach ?>
	          </ul>

	        </div>
	      <?php endif ?>

	    </div>

    <div class="threecol last">
      Il pool di argomenti considerato:<br/><br/>
      <ul>
        <?php foreach ($argomentis as $name => $id): ?>
          <li><?php echo link_to($name, '@argomento_sioccupanodi?triple_value='.$name.'&ramo='.$ramo) ?></li>
        <?php endforeach ?>
      </ul>
      <br/><br/>
      <strong><?php echo link_to("Vai alla classifica dei ".($ramo=='C'?'senatori':'deputati'),"/argomenti_actionaid/".($ramo=='C'?'S':'C')) ?></strong>
      <br/><br/>
    </div>
    
	  
  </div>

<?php endif ?>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  <?php echo link_to('argomenti', '@argomenti') ?> /
  classifica ActionAid
<?php end_slot() ?>
