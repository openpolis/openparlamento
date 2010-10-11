<form action="<?php echo url_for('@set_atto_is_main_unified') ?>" method="post">
  <input type="hidden" name="atto_id" value="<?php echo $atto->getId()?>"/>
  <input type="checkbox" name="is_main_unified" id="is_main_unified" value="1"
         <?php echo $atto->getIsMainUnified()?"checked":"" ?>/> <label for="is_main_unified">questo &egrave; l'atto principale</label>
       
  <input type="submit" id="cambia" value="Cambia" name="cambia">  
</form>