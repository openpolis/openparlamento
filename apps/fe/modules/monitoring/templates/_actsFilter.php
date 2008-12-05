<?php echo use_helper('AdvancedOptionsForSelect') ?>


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
                          adv_objects_for_select($tags, 'getId', 'getTripleValue', $selected_tag_id, 
                                                 'include_zero_custom=tutti')) ?>
                          
    <?php echo select_tag('filter_act_type_id', 
                          adv_objects_for_select($types, 'getId', 'getDenominazione', $selected_act_type_id,
                                                 'include_zero_custom=tutti')) ?>

    <?php echo select_tag('filter_act_ramo', 
                          options_for_select(array('0' => 'tutte',
                                                   'C' => 'camera',
                                                   'S' => 'senato'), $selected_act_ramo)) ?>

    <?php echo select_tag('filter_act_stato', 
                          options_for_select(array('0' => 'tutti',
                                                   'IC' => 'in corso',
                                                   'AP' => 'approvati',
                                                   'RE' => 'respinti',
                                                   'CO' => 'tutti i conclusi'), $selected_act_stato)) ?>
                                                   
    <?php echo submit_image_tag('btn-applica.png', array('id' => 'disegni-decreti-filter-apply', 'alt' => 'applica', 'style' => 'display: none;', 'name' => 'disegni-decreti-filter-apply' )) ?>
  </fieldset>
</form>