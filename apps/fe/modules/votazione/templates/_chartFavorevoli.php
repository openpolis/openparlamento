<?php if ($fav>0) : ?>
   <h5 class="subsection"><?php echo 'Favorevoli: '.$fav. ' ('.round($fav*100/($fav+$contr+$ast),1).'%)' ?></h5>
   <p align="center">
   <?php echo image_tag($gchartFav); ?>
   </p>
<?php endif; ?>	

<?php if ($contr>0) : ?>
   <h5 class="subsection"><?php echo 'Contrari: '.$contr. ' ('.round($contr*100/($fav+$contr+$ast),1).'%)' ?></h5>
   <p align="center">
   <?php echo image_tag($gchartContr,'align=middle'); ?>
   </p>
<?php endif; ?>	

<?php if ($ast>0) : ?>
   <h5 class="subsection"><?php echo 'Astenuti: '.$ast. ' ('.round($ast*100/($fav+$contr+$ast),1).'%)' ?></h5>
   <p align="center">
   <?php echo image_tag($gchartAst); ?>
   </p>
<?php endif; ?>	



