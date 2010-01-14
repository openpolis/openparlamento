<?php echo use_helper('PagerNavigation'); ?>

<div class="W45_100 float-left">
  <h4 class="subsection">Voti simili su tutte le votazioni elettroniche: <?php echo $compare.' ('.$perc.'%)' ?></h4>
  <div class="W45_100 float-left">
    <div class="float-container">
      <p style="padding:10px 5px 5px 5px;">
      <?php echo link_to($parlamentare1->getOppPolitico()->getNome().' '.$parlamentare1->getOppPolitico()->getCognome(),'parlamentare/'.$parlamentare1->getOppPolitico()->getId()).
       ' e '. link_to($parlamentare2->getOppPolitico()->getNome().' '.$parlamentare2->getOppPolitico()->getCognome(),'parlamentare/'.$parlamentare2->getOppPolitico()->getId()) ?>
       hanno espresso lo stesso voto <strong><?php echo $compare ?></strong> volte <?php echo ' ('.$perc.'%)' ?>  
       su un totale di <strong><?php echo $numero_voti ?></strong> votazioni in cui sono stati entrambi presenti.
       </p>
     </div>
   </div>
   <div class="W45_100 float-left">
     <?php echo image_tag($gchartVoti); ?>
   </div>
</div> 
