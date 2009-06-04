<div class="evidence-box float-container">
	<h5 class="subsection">Vota più spesso come...</h5>
	<div class="pad10">
		<ul>
		  <?php foreach ($nearest as $i => $politico): ?>
		    <li>
		      <?php echo $i ?>.
		      <?php echo link_to($politico['nomecognome'] . ($politico['samegroup']?"":" (".$politico['gruppo'].")"), 
		                        '@parlamentare?id='.$politico['id'], 
		                          array( 'class' => 'folk1' . ($politico['samegroup']?' green':' violet'), 
		                                 'title' => number_format($politico['similarita'], 2))) ?>
		    </li>
		    <?php if ($i == 10): ?>
		      <li>...</li>
		    <?php endif ?>
		  <?php endforeach ?>
		</ul>					
		<p style="text-align: right; margin-top: 10px">
		  <span  class="folk0 green">del suo gruppo</span>
		  <span class="folk0 violet">di altri gruppi</span>
		</p>
	</div>
	<!--
	<?php if($carica->getTipoCaricaId()==1) : ?>
	   <?php include_component('parlamentare', 'tendinaParlamentari',array('num_tendine' => '1','parlamentare_id'=>$parlamentare->getId(), 'ramo' => '1', 'select2'=>'null')) ?>  
        <?php else : ?>
           <?php include_component('parlamentare', 'tendinaParlamentari',array('num_tendine' => '1','parlamentare_id'=>$parlamentare->getId(), 'ramo' => '2', 'select2'=>'null')) ?>
        <?php endif; ?>  
        --> 
        
</div>		
