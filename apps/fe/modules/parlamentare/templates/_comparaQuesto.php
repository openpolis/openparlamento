<?php echo use_helper('AdvancedOptionsForSelect') ?>

<div class="evidence-box float-container">
 
	<h5 class="subsection">Confronta  <?php echo $parlamentare->getNome().' '.$parlamentare->getCognome() ?> con <?php echo ($ramo==1 ?'l\'onorevole':'il senatore') ?> ... <span class="tools-container"><?php echo image_tag('/images/ico-new.png', array('width' => '18', 'height' => '10')) ?></span></h5>
	<div class="pad10">

<?php $arr_tendina=array(); ?>
<?php while($parlamentari->next()): ?>
  <?php $arr_tendina[$parlamentari->getInt(1)]=$parlamentari->getString(2)." ".$parlamentari->getString(3); ?>
<?php endwhile; ?>


   <?php echo form_tag('/parlamentare/comparaDeputati') ?>
      

<input type="hidden" name="parlamentare1" id="parlamentare1" value="<?php echo $parlamentare->getId() ?> " />
<p style="padding-bottom:5px; font-size:13px">Scegli un <?php echo ($ramo=='1' ? 'deputato' : 'senatore') ?> per il confronto:</p> 
<?php echo select_tag('parlamentare2', 
                          options_for_select($arr_tendina,$select2)) ?>
<input type="hidden" name="ramo" id="ramo" value="<?php echo $ramo ?> " />                          

                              
                                               

<?php echo submit_image_tag('btn-applica.png', array('id' => 'tendina', 'alt' => 'applica', 'name' => 'tendina' )) ?>

</div>
</div>
