<?php if (count($relazioni)!=0) : ?>
<p><strong>
<?php echo ($relazioni[0][1]=='T. U. con') ? 'Testo unificato con ' : $relazioni[0][1] ?>
</strong>
  
    <?php for ($i=0;$i<count($relazioni);$i++) : ?>
         <?php if ($i!=0) : ?>
             <?php echo "," ?>
         <?php endif; ?>
         <?php echo link_to($relazioni[$i][2],'singolo_atto/'.$relazioni[$i][0]) ?>
         
     <?php endfor ?>   
</p>
<br />    
<?php endif; ?> 