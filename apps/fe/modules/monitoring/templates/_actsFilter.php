<?php echo use_helper('Object') ?>


<?php echo form_tag('#', array("id"=>"disegni-decreti-filter")) ?>
  <fieldset class="labels">
    <label for="topic">argomento:</label>
    <label for="type">tipologia:</label>
    <label for="room">ramo:</label>
    <label for="status">stato:</label>
  </fieldset>
  <p>filtra per</p>
  <fieldset>
    <?php echo select_tag('filter_tag_id', 
                          objects_for_select($tags, 'getId', 'getTripleValue', $selected_tag_id, 'include_custom=tutti')) ?>
                          
    <?php echo select_tag('filter_act_type_id', 
                          objects_for_select($types, 'getId', 'getDenominazione', $selected_act_type_id, 'include_custom=tutti')) ?>

    <?php echo select_tag('filter_act_ramo', 
                          options_for_select(array('0' => 'tutte',
                                                   'C' => 'camera',
                                                   'S' => 'senato'), $selected_act_ramo)) ?>

    <select id="status" name="status">
      <option value="0" selected="selected">tutti</option>
      <option value="1">in corso</option>
      <option value="2">approvato</option>
      <option value="3">respinto</option>
      <option value="4">tutti i conclusi</option>								
    </select>
    <?php echo submit_image_tag('btn-applica.png', array('id' => 'disegni-decreti-filter-apply', 'alt' => 'applica', 'style' => 'display: none;', 'name' => 'disegni-decreti-filter-apply' )) ?>
  </fieldset>
</form>