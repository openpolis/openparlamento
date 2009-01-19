<?php echo use_helper('AdvancedOptionsForSelect') ?>

<?php echo form_tag('#', array("id"=>"disegni-decreti-filter")) ?>
  <fieldset class="labels">
    <label for="filter_tags_category">argomento:</label>
    <label for="filter_type">tipo:</label>
    <label for="filter_ramo">ramo:</label>
    <label for="filter_esito">stato:</label>
  </fieldset>
  <p>filtra per</p>
  <fieldset>

    <?php echo select_tag('filter_tags_category', 
                          adv_objects_for_select($tags_categories, 'getId', 'getDenominazione', $selected_tags_category, 
                                                 'include_zero_custom=tutti')) ?>
                          
   <?php echo select_tag('filter_type', 
                         options_for_select(array('0' => 'tutte',
                                                  '1' => 'solo voti finali'), $selected_type)) ?>
    <?php echo select_tag('filter_ramo', 
                          options_for_select(array('0' => 'tutte',
                                                   'C' => 'camera',
                                                   'S' => 'senato'), $selected_ramo)) ?>

    <?php echo select_tag('filter_esito', 
                          options_for_select(array('0' => 'tutti',
                                                   'Appr.' => 'approvato',
                                                   'Resp.' => 'respinto'), $selected_esito)) ?>
                                                   
    <?php echo submit_image_tag('btn-applica.png', array('id' => 'disegni-decreti-filter-apply', 'alt' => 'applica', 'style' => 'display: none;', 'name' => 'disegni-decreti-filter-apply' )) ?>
  </fieldset>
</form>
