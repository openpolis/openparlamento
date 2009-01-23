<div id="tag_add">
  Cerca tag: 
  <?php echo form_tag('#', array('id' => 'autocompleter', 'style' => 'display:inline')); ?>
    <input style="border:1px solid gray;" type="text" id="tags_autocomplete" name="tags" 
           autocomplete="off" value="" size="20"/>
    <?php echo submit_tag('Aggiungi', array('id' => 'aggiungi', 'name'=>'aggiungi', 'onClick' => 'return false;')) ?>
    <div id="autocomplete_choices" class="autocomplete"></div>
  </form>
  <?php echo image_tag('indicator.gif', array('id'=>'autocomplete_indicator', 'style' => 'display:none')) ?>
</div>      
      

