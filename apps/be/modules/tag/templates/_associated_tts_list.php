<?php foreach ($tag->getOppTagHasTtsJoinOppTeseott() as $tt): ?>
  <div><?php echo link_to($tt->getOppTeseott(), 'teseott/edit?id='.$tt->getOppTeseott()->getId()) ?></div>
<?php endforeach ?>  
