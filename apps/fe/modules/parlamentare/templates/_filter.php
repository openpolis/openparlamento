<?php echo form_tag('#', array("id"=>"disegni-decreti-filter")) ?>
  <fieldset class="labels">
    <label for="group">gruppo:</label>
    <label for="area">circoscrizione:</label>	
  </fieldset>
  <p>filtra per</p>
  <fieldset>
    <select id="group" name="group">
      <option value="0" selected="selected">tutti</option>
      <option value="1">1. lorem ipsum</option>
      <option value="2">2. lorem ipsum</option>
    </select>				
    <select id="area" name="area">
      <option value="0" selected="selected">tutte</option>
      <option value="1">1. lorem ipsum</option>
      <option value="2">2. lorem ipsum</option>
    </select>
    <?php echo submit_image_tag('btn-applica.png', array('id' => 'disegni-decreti-filter-apply', 'alt' => 'applica', 'style' => 'display: none;', 'name' => 'disegni-decreti-filter-apply' )) ?>
  </fieldset>
</form>