<?php if (is_array($descrizione_cariche) ) : ?>  <p>
  <?php $minuscole = array("ò", "à", "ù", "è", "ì");
       $maiuscole = array("&Ograve;", "&Agrave;", "&Ugrave;", "&Egrave;", "&Igrave;");
  ?>     
<?php 
foreach ($descrizione_cariche as $descrizione_carica) : ?>

   <?php $descrizione_carica=utf8_decode($descrizione_carica) ?>
   <strong><?php echo (str_replace($minuscole, $maiuscole ,strtoupper($descrizione_carica))) ?></strong><br />
    
<?php endforeach; ?>
</p> 
<?php endif; ?>