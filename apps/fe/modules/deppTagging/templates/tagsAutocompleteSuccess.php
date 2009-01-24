<?php
foreach ($tags as $tag) {
	echo strtolower($tag->getTripleValue()) . "|" . $tag->getTopTerms() . "|" . $tag->getName() . "\n";
}
?>
		  
