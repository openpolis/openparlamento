<?php echo use_helper('AdvancedOptionsForSelect') ?>


<?php echo form_tag('#', array("id"=>"disegni-decreti-filter", "class" => $active?'active':'')) ?>
  <fieldset class="labels">
    <label for="filter_tag_id">argomento:</label>
    <label for="filter_act_type_id">tipologia:</label>
    <label for="filter_act_ramo">ramo:</label>
    <!--<label for="filter_date">data:</label>-->
    <label for="filter_main_all">principali:</label>
  </fieldset>
  <p>filtra per</p>
  <fieldset>
    <?php echo select_tag('filter_tag_id', 
                          adv_objects_for_select($tags, 'getId', 'getTripleValue', $selected_tag_id, 
                                                 'include_zero_custom=tutti')) ?>
                          
    <?php echo select_tag('filter_act_type_id', 
                          adv_objects_for_select($types, 'getId', 'getDenominazione', $selected_act_type_id,
                                                 'include_zero_custom=tutte')) ?>

    <?php echo select_tag('filter_act_ramo', 
                          options_for_select(array('0' => 'tutti',
                                                   'C' => 'camera',
                                                   'S' => 'senato'), $selected_act_ramo)) ?>
    <!--
    <?php echo select_tag('filter_date', 
                          options_for_select(array('0' => 'tutte',
                                                   'W' => 'ultima settimana',
                                                   'M' => 'ultimo mese'), $selected_date)) ?>
    -->
    <?php echo select_tag('filter_main_all',
                          options_for_select(array('main' => 'principali',
                                                   'all'  => 'tutte'), $selected_main_all))?>

    <?php echo submit_image_tag('btn-applica.png', array('id' => 'disegni-decreti-filter-apply', 'alt' => 'applica', 'style' => 'display: none;', 'name' => 'disegni-decreti-filter-apply' )) ?>
  </fieldset>
</form>