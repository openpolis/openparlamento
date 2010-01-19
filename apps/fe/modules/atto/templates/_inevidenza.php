<ul id="law-n-acts-proposals">
 <?php foreach ($lanci as $lancio) : ?>  
     <?php include_partial('lanci',array('lancio' => $lancio)); ?> 
  <?php endforeach; ?>	
</ul>
