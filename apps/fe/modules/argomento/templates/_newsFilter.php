<?php echo form_tag('#', array("id"=>"disegni-decreti-filter")) ?>
  <fieldset class="labels">
    <label for="filter_main_all">principali:</label>
  </fieldset>
  <p>filtra per</p>
  <fieldset>
    <?php echo select_tag('filter_main_all',
                          options_for_select(array('main' => 'principali',
                                                   'all'  => 'tutte'), $selected_main_all))?>

    <?php echo submit_image_tag('btn-applica.png', array('id' => 'disegni-decreti-filter-apply', 'alt' => 'applica', 'style' => 'display: none;', 'name' => 'disegni-decreti-filter-apply' )) ?>
  </fieldset>
</form>