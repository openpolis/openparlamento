<ul>
  <?php foreach ($tags as $tag): ?>
    <?php if (in_array($tag, $my_tags)): ?>
      <li id="tag_<?php echo $tag->getId()?>" title="click per rimuovere dai tuoi tag" class="selected"><?php echo $tag->getTripleValue() ?></li>
    <?php else: ?>  
      <li id="tag_<?php echo $tag->getId()?>" title="click per aggiungere ai tuoi tag"><?php echo $tag->getTripleValue() ?></li>
    <?php endif ?>
  <?php endforeach ?>
</ul>

