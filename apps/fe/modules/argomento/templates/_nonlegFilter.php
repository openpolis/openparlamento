<?php echo use_helper('AdvancedOptionsForSelect') ?>


<?php echo form_tag('#', array("id"=>"disegni-decreti-filter")) ?>
  <fieldset class="labels">
    <label for="filter_act_type">tipologia:</label>
    <label for="filter_act_ramo">ramo:</label>
    <label for="filter_act_stato">stato:</label>
  </fieldset>
  <p>filtra per</p>
  <fieldset>
    <?php echo select_tag('filter_act_nonleg_type', 
                          options_for_select(array('0'  => 'tutte',
                                                   '2'  => 'Mozione',
                                                   '3'  => 'Interpellanza',
                                                   '4'  => 'Interrogazione a risposta orale',
                                                   '5'  => 'Interrogazione a risposta scritta',
                                                   '6'  => 'Interrogazione a risposta in commissione',
                                                   '7'  => 'Risoluzione in assemblea',
                                                   '8'  => 'Risoluzine in commissione',
                                                   '9'  => 'Risoluzione conclusiva',
                                                   '10' => 'ODG - Assemblea',
                                                   '11' => 'ODG - Commissione',
                                                   '13' => 'Comunicato del Governo',
                                                   '14' => 'Audizione'), $selected_act_nonleg_type)) ?>

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