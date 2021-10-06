<?php if (count($tax)>0) : ?>

  <?php $cn=0; ?>
  <h5 class="subsection-alt" style="margin-top:0px;">Dichiarazioni patrimoniali: redditi, beni e spese elettorali  <span class="tools-container"><?php echo image_tag('/images/ico-new.png', array('width' => '18', 'height' => '10')) ?></span></h5>
  <div style="font-size:14px; margin-bottom:20px;">
  <?php if ($patrimoni>0) :?>
     <p style="padding-top:5px;padding-bottom: 10px;">
         <?php echo link_to(image_tag('/images/banner-patrimoni-big.png', 
                                            array('alt' => 'vai al sito Patrimoni Trasparenti')), 
                                           'http://patrimoni.openpolis.it/#/scheda/'. 											$parlamentare->getCognome().'-'.$parlamentare->getNome().'/'.$parlamentare->getId()) ?>
	 </p>
  <?php endif; ?>
  <p>
  Scarica le dichiarazioni:
  <?php foreach ($tax as $k=>$t) : ?>
  	<?php if ($cn>0 && $cn<count($tax)) : ?>
		<?php echo " | "; ?>
	<?php endif; ?>
  	<?php echo "<strong>".link_to("anno ".$k, 'https://s3.amazonaws.com/op_patrimoni/dichiarazioni/pdf/'.$parlamentare->getId().'_'.$k.'.pdf')."</strong>"; ?>
	<?php $cn=$cn+1; ?>
  <?php endforeach; ?>
  </p>
</div>
<?php endif; ?>
