<div class="W45_100 float-right">
  <?php if (count($lontani)>0) : ?>
  <h5 class="subsection" >i politici che <span style="color: red;">meno</span> ti rappresentano</h5>
  <table class="list-table column-table">
  <tbody>
  <?php foreach ($lontani as $pos=>$lontano) : ?>
  <tr><th scope="row">
  <h3 class="position-red"><?php echo $pos+1 ?></h3>
  <p class="politician-id">
  <?php echo image_tag(OppPoliticoPeer::getThumbUrl($lontano[1]->getOppPolitico()->getId()), 
                       'icona parlamentare') ?>
  <?php echo link_to($lontano[1]->getOppPolitico()->getNome()." ".$lontano[1]->getOppPolitico()->getCognome(),'/parlamentare/'.$lontano[1]->getOppPolitico()->getId())?>
  <?php $gruppi = OppCaricaHasGruppoPeer::doSelectGruppiPerCarica($lontano[1]->getId()) ?>  	
  <?php foreach($gruppi as $nome => $gruppo): ?>
  <?php if(!$gruppo['data_fine']): ?>
   <?php print" (". $nome.")" ?>
  <?php endif; ?> 
  <?php endforeach; ?>
  <?php //echo " | ".$lontano[0] ?>
  </p>
  </th></tr>
  <?php endforeach ?>
  </tbody>
  </table>
  <?php endif ?>
</div>  

<div class="W45_100 float-left">
<?php if (count($vicini)>0) : ?>
<h5 class="subsection" >i politici che <span style="color: green;">pi&ugrave;</span> ti rappresentano</h5>
<table class="list-table column-table">
<tbody>
<?php foreach ($vicini as $pos=>$vicino) : ?>
<tr><th scope="row">
<h3 class="position-green"><?php echo $pos+1 ?></h3>
<p class="politician-id">
<?php echo image_tag(OppPoliticoPeer::getThumbUrl($vicino[1]->getOppPolitico()->getId()), 
                     'icona parlamentare') ?>
<?php echo link_to($vicino[1]->getOppPolitico()->getNome()." ".$vicino[1]->getOppPolitico()->getCognome(),'/parlamentare/'.$vicino[1]->getOppPolitico()->getId()) ?>
<?php $gruppi = OppCaricaHasGruppoPeer::doSelectGruppiPerCarica($vicino[1]->getId()) ?>  	
<?php foreach($gruppi as $nome => $gruppo): ?>
<?php if(!$gruppo['data_fine']): ?>
 <?php print" (". $nome.")" ?>
<?php endif; ?> 
<?php endforeach; ?>
<?php //echo " | ".$vicino[0] ?>
</p>
</th></tr>
<?php endforeach ?>
</tbody>
</table>
<?php endif ?>
</div>

