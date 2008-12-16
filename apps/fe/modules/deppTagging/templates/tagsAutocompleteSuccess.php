<ul>
	<?php foreach ($tags as $tag) :?>
	  <?php $tripleVal = strtolower($tag->getTripleValue()); ?>
		<li id="<?php echo $tag->getId()?>">
		  <?php echo substr($tripleVal, 0, strpos($tripleVal, $my_str)) ?><span style="color: #222; font-weight: bold"><?php echo $my_str; ?></span><?php echo substr($tripleVal, strlen($my_str)+strpos($tripleVal, $my_str)) ?><br/>
		  <span style="font-size: 11px">(<?php echo $tag->getTopTerms() ?>)</span>
		</li>
  <?php endforeach; ?>
</ul>