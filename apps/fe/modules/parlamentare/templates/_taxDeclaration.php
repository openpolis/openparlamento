<?php if (count($tax)>0) : ?>

  <?php $cn=0; ?>
  <h5 class="subsection-alt" style="margin-top:0px;">Dichiarazioni patrimoniali: redditi, beni e spese elettorali  <span class="tools-container"><?php echo image_tag('/images/ico-new.png') ?></span></h5>
  <div style="font-size:14px; margin-bottom:20px;">
  Ha dato il consenso per la pubblicazione online della sua dichiarazione patrimoniale.
  <p>
  Scarica le dichiarazioni:
  <?php foreach ($tax as $k=>$t) : ?>
  	<?php if ($cn>0 && $cn<count($tax)) : ?>
		<?php echo " | "; ?>
	<?php endif; ?>
  	<?php echo "<strong>".link_to("anno ".$k,'http://politici.openpolis.it/tax/pdf/'.$t.'_'.$k.'.pdf')."</strong>"; ?>
	<?php $cn=$cn+1; ?>
  <?php endforeach; ?>
  </p>
<p style="padding-top:3px;">Per la lista completa delle dichiarazioni patrimoniali di altri politici <a href="http://politici.openpolis.it/dichiarazioni-patrimoniali-dei-politici-eletti">clicca qui</a>.</p>
</div>
<?php endif; ?>
