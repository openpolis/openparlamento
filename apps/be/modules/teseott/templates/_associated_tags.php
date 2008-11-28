<?php foreach ($opp_teseott->getOppTagHasTtsJoinTag() as $tag): ?>
  <div><?php echo link_to($tag->getTag(), 'tag/edit?id='.$tag->getTag()->getId()) ?></div>
<?php endforeach ?>  
