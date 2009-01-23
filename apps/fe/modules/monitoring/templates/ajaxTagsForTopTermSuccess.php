<?php foreach ($tags as $tag): ?>
  <?php if (in_array($tag, $my_tags)): ?>
    <li id="tag_<?php echo $tag->getId()?>" title="click per rimuovere dai tuoi tag" class="monitoring">
      <?php echo link_to(strtolower($tag->getTripleValue()), 
                         'monitoring/removeTagFromMyMonitoredTags?name='.$tag->getName()) ?>
    </li>
  <?php else: ?>  
    <li id="tag_<?php echo $tag->getId()?>" title="click per aggiungere ai tuoi tag">
      <?php echo link_to(strtolower($tag->getTripleValue()),
                         'monitoring/addTagToMyMonitoredTags?name='.$tag->getName()) ?>
    </li>
  <?php endif ?>
<?php endforeach ?>

