<?php if (count($tags) > 0): ?>
  <div class="evidence-box float-container">
  	<h5 class="subsection">Si occupa di...</h5>
  	<p class="pad10">
  	  <?php foreach ($tags as $triple_value => $relevance): ?>
  	    <?php echo link_to(strtolower($triple_value), '@argomento?triple_value='.$triple_value, array('class' => 'folk2')) ?>
  	    &nbsp;&nbsp;
  	  <?php endforeach ?>
  	</p>
	  <?php if ($n_remaining_tags > 0): ?>
	  <p class="pad10">
	   ... e altri <?php echo $n_remaining_tags ?> argomenti
	   </p>
	  <?php endif ?>
  </div>		  
<?php endif ?>
