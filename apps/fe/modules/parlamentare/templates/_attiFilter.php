<?php echo use_helper('AdvancedOptionsForSelect') ?>


<?php echo form_tag('#', array("id"=>"disegni-decreti-filter")) ?>
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
                                                   '12' => 'decreti legge',
                                                   '15' => 'decreti legislativi - attuativo di legge delega',
                                                   '16' => 'decreti legislativi - attuativo di direttive comunitarie',
                                                   '17' => 'decreti legislativi - attuativo di statuti speciali',
                                                   '2' => 'attuativo di legge delega',
                                                   '3' => 'interpellanza',
                                                   '4' => 'interrogazione a risposta orale',
                                                   '5' => 'interrogazione a risposta scritta',
                                                   '6' => 'interrogazione a risposta in commissione',
                                                   '7' => 'risoluzione in assemblea',
                                                   '8' => 'risoluzione in commissione',
                                                   '9' => 'risoluzione conclusiva',
                                                   '10' => 'odg - in assemblea',
                                                   '11' => 'odg - in commissione',
                                                   '13' => 'comunicato del governo',
                                                   '14' => 'audizione'), $selected_act_type)) ?>

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