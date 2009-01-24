<?php foreach ($tags as $tag_name => $popularity): ?>
  <?php list($tag, $ns, $key, $value) = deppPropelActAsTaggableToolkit::extractTriple($tag_name); ?>
  <?php if (array_key_exists($tag_name, $my_tags)): ?>
    <li title="click per rimuovere dai tuoi tag" class="monitoring">
      <?php 
        echo link_to(strtolower($value), 
                     'monitoring/removeTagFromMyMonitoredTags?name='.$tag, 
                     array('class' => 'folk'.($popularity+3))); 
      ?>
    </li>
  <?php else: ?>  
    <li title="click per aggiungere ai tuoi tag">
      <?php 
        echo link_to(strtolower($value), 
                     'monitoring/addTagToMyMonitoredTags?name='.$tag, 
                     array('class' => 'folk'.($popularity+3))); 
      ?>
    </li>
  <?php endif ?>
<?php endforeach ?>

