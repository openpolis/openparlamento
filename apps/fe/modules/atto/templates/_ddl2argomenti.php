<?php foreach($tags as $tag): ?>
  <?php echo TagPeer::retrieveByPk($tag[0])->getTripleValue(). " - ".$tag[1]. "<br/>" ?>
<?php endforeach ?>  