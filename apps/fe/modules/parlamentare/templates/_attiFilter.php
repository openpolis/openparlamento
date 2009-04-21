<?php echo use_helper('AdvancedOptionsForSelect') ?>


<?php echo form_tag('#', array("id"=>"disegni-decreti-filter", "class" => $active?'active':'')) ?>
  <fieldset class="labels">
    <label for="filter_tags_category">categoria:</label>
    <label for="filter_act_type">tipo:</label>
    <label for="filter_act_firma">come:</label>
    <label for="filter_act_stato">stato:</label>
  </fieldset> 
  <p>filtra per</p>
  <fieldset>
    <?php echo select_tag('filter_tags_category', 
                          adv_objects_for_select($tags_categories, 'getId', 'getDenominazione', $selected_tags_category, 
                                                 'include_zero_custom=tutti')) ?>
                          
    <?php echo select_tag('filter_act_type', 
                          options_for_select(array('0' => 'tutte',
                                                   '1' => 'disegni di legge',
                                                   '2' => 'mozioni',
                                                   '7' => 'risoluzioni in assemblea',
                                                   '8' => 'risoluzioni in commissione',
                                                   '9' => 'risoluzioni conclusive',
                                                   '10' => 'odg - in assemblea',
                                                   '11' => 'odg - in commissione',
                                                   '3' => 'interpellanze',
                                                   '4' => 'interrogazioni a risposta orale',
                                                   '5' => 'interrogazioni a risposta scritta',
                                                   '6' => 'interrogazioni a risposta in commissione'), $selected_act_type)) ?>

    <?php echo select_tag('filter_act_firma', 
                          options_for_select(array('0' => 'tutte',
                                                   'P' => 'primo firmatario',
                                                   'C' => 'co-firmatario',
                                                   'R' => 'relatore'), $selected_act_firma)) ?>

    <?php echo select_tag('filter_act_stato', 
                          options_for_select(array('0' => 'tutti',
                                                   'IC' => 'in corso',
                                                   'AP' => 'approvati',
                                                   'RE' => 'respinti',
                                                   'CO' => 'tutti i conclusi'), $selected_act_stato)) ?>
                                                   
    <?php echo submit_image_tag('btn-applica.png', array('id' => 'disegni-decreti-filter-apply', 'alt' => 'applica', 'style' => 'display: none;', 'name' => 'disegni-decreti-filter-apply' )) ?>
  </fieldset>
</form>