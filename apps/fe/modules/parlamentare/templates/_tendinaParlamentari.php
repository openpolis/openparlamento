<?php echo use_helper('AdvancedOptionsForSelect') ?>
<?php $arr_tendina=array(); ?>
<?php while($parlamentari->next()): ?>
  <?php $arr_tendina[$parlamentari->getInt(1)]=$parlamentari->getString(2)." ".$parlamentari->getString(3); ?>
<?php endwhile; ?>


   <?php echo form_tag('/parlamentare/comparaDeputati') ?>
      
<?php if ($num_tendine == 2) : ?>      

             
<?php echo select_tag('parlamentare1', 
                          options_for_select($arr_tendina,$select1)) ?>
<?php else : ?>
<input type="hidden" name="parlamentare1" id="parlamentare1" value="<?php echo $parlamentare_id ?> " />
<?php endif; ?> 
<?php echo select_tag('parlamentare2', 
                          options_for_select($arr_tendina,$select2)) ?>
<input type="hidden" name="ramo" id="ramo" value="<?php echo $ramo ?> " />                          

                              
                                               

<?php echo submit_image_tag('btn-applica.png', array('id' => 'tendina', 'alt' => 'applica', 'name' => 'tendina' )) ?> 