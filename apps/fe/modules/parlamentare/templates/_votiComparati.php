<?php echo use_helper('PagerNavigation'); ?>

<div class="W45_100 float-left">
  <h4 class="subsection">Hanno espresso lo stesso voto <strong><?php echo $compare ?></strong> volte <?php echo ' ('.$perc.'%)' ?>
       nelle <?php echo $numero_voti ?></strong> votazioni in cui sono stati ENTRAMBI PRESENTI.</h4>
   <div class="W45_100 float-left">
     <?php echo image_tag($gchartVoti); ?>
   </div>
</div> 
