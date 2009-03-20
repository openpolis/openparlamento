<?php echo use_helper('AdvancedOptionsForSelect') ?>


<?php echo form_tag('#', array("id"=>"disegni-decreti-filter", "class" => $active?'active':'')) ?>
  <fieldset class="labels">
    <label for="filter_vote_type">tipo:</label>
    <label for="filter_vote_vote">voto:</label>
    <label for="filter_vote_result">esito:</label>
    <label for="filter_vote_rebel">ribelle:</label>
  </fieldset>
  <p>filtra per</p>
  <fieldset>
    <?php echo select_tag('filter_vote_type', 
                          options_for_select(array('0' => 'tutte le votazioni',
                                                   '1' => 'votazioni finali'), $selected_vote_type)) ?>

    <?php echo select_tag('filter_vote_vote', 
                          options_for_select(array('0' => 'tutti',
                                                   'Favorevole' => 'favorevole',
                                                   'Contrario' => 'contrario',
                                                   'Astenuto' => 'astenuto'), $selected_vote_vote)) ?>

    <?php echo select_tag('filter_vote_result', 
                          options_for_select(array('0' => 'tutti',
                                                   'Appr.' => 'approvata',
                                                   'Resp.' => 'respinta',
                                                   'Annu.' => 'annullata'), $selected_vote_result)) ?>

    <?php echo select_tag('filter_vote_rebel', 
                          options_for_select(array('0' => 'tutte',
                                                   '1' => 'ribelle'), $selected_vote_rebel)) ?>
                                                   
    <?php echo submit_image_tag('btn-applica.png', array('id' => 'disegni-decreti-filter-apply', 'alt' => 'applica', 'style' => 'display: none;', 'name' => 'disegni-decreti-filter-apply' )) ?>
  </fieldset>
</form>