<div class="float-left">
  <?php if (count($related_tags) > 0): ?>
  	<h6>argomenti correlati</h6>
  	<p class="pad10">
  	  <?php foreach ($related_tags as $tag_name => $relevance): ?>
  	    <?php list($tag, $namespace, $key, $value) = deppPropelActAsTaggableToolkit::extractTriple($tag_name) ?>
  	    <?php echo link_to(strtolower($value), '@argomento?triple_value='.$value, array('class' => 'folk'.$relevance)) ?>
  	    &nbsp;&nbsp;
  	  <?php endforeach ?>
  	</p>
  <?php endif ?>
</div>

