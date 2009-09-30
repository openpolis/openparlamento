<?php if (count($relazioni)!=0) : ?>
<p><strong>
<?php if ($relazioni[0][3]==0) : ?>
   <?php echo ($relazioni[0][1]=='T. U. con') ? 'Testo unificato con ' : $relazioni[0][1] ?>
<?php endif; ?> 

<?php if ($relazioni[0][3]==1) : ?>
   <?php echo "DDL derivati per stralcio: " ?>
<?php endif; ?> 

<?php if ($relazioni[0][3]==2) : ?>
   <?php echo "derivato dallo stralcio del ddl " ?>
<?php endif; ?> 
   
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