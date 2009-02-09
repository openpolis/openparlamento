<?php foreach ($tags as $tag_name => $popularity): ?>
  <?php list($tag, $ns, $key, $value) = deppPropelActAsTaggableToolkit::extractTriple($tag_name); ?>
  <li class="tags">
    <?php 
      echo link_to(strtolower($value), 
                   "@argomento?triple_value=${value}", 
                   array('class' => 'folk'.($popularity+3))); 
    ?>
  </li>
<?php endforeach ?>