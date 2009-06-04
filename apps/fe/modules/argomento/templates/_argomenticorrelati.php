<?php if (count($related_tags) > 0): ?>
<div class="evidence-box float-container">
  
  <h5 class="subsection">Argomenti correlati</h5>
  	<p class="pad10">
  	  <?php foreach ($related_tags as $tag_name => $relevance): ?>
  	    <?php list($tag, $namespace, $key, $value) = deppPropelActAsTaggableToolkit::extractTriple($tag_name) ?>
  	    <?php echo link_to(strtolower($value), '@argomento?triple_value='.$value, array('class' => 'folk'.$relevance)) ?>
  	    &nbsp;&nbsp;
  	  <?php endforeach ?>
  	</p>
  
</div>
<?php endif ?>
