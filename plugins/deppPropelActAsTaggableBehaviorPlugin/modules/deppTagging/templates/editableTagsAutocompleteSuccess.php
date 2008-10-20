<ul>
	<?php foreach ($tags as $tag) :?>
	  <?php $tripleVal = $tag->getTripleValue(); ?>
		<li id="<?php echo $tag->getId()?>">
		  <span style="color: #222; font-weight: bold"><?php echo $my_str; ?></span><?php echo substr($tripleVal, strlen($my_str)+strpos($tripleVal, $my_str)) ?>
		</li>
  <?php endforeach; ?>
</ul>