<?php if (count($relazioni)!=0) : ?>
<p>
<?php $count0=0; ?>
<?php $count1=0; ?>
<?php $count2=0; ?>
 <?php foreach ($relazioni as $relazione) : ?>
    
    <?php if ($relazione[3]==0) : ?>
        <?php if ($count0==0) : ?>
          <?php echo "<strong>"; ?>
          <?php echo ($relazione[1]=='T. U. con') ? 'Testo unificato con ' : $relazione[1]; ?>
          <?php $count0=1; ?>
          <?php echo "</strong>"; ?>
        <?php endif; ?>
        <?php echo link_to($relazione[2],'singolo_atto/'.$relazione[0]); ?>
    <?php endif; ?> 
    
    
    <?php if ($relazione[3]==1) : ?>
        <?php if ($count1==0) : ?>
          <?php echo "<strong>"; ?>
          <?php echo "DDL derivati per stralcio: "; ?>
          <?php $count1=1; ?>
          <?php echo "</strong>"; ?>
        <?php endif; ?>
        <?php echo link_to($relazione[2],'singolo_atto/'.$relazione[0]); ?>
    <?php endif; ?> 
    
     
    <?php if ($relazione[3]==2) : ?>
        <?php if ($count2==0) : ?>
          <?php echo "<strong>"; ?>
          <?php echo "derivato dallo stralcio del ddl "; ?>
          <?php $count2=1; ?>
          <?php echo "</strong>"; ?>
        <?php endif; ?>
        <?php echo link_to($relazione[2],'singolo_atto/'.$relazione[0]); ?>
    <?php endif; ?> 
    
   <?php endforeach; ?>    
       
</p> 
<br />
<?php endif; ?> 