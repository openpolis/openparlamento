<?php echo use_helper('AdvancedOptionsForSelect') ?>

<?php echo form_tag('#', array("id"=>"disegni-decreti-filter", "class" => $active?'active':'')) ?>
  <fieldset class="labels">
    <label for="filter_tags_category">categoria:</label>
    <label for="filter_data">data:</label>
  </fieldset>
  <p>filtra per</p>
  <fieldset>
    <?php echo select_tag('filter_tags_category', 
                          adv_objects_for_select($tags_categories, 'getId', 'getDenominazione', $selected_tags_category, 
                                                 'include_zero_custom=tutti')) ?>

    <?php echo select_tag('filter_data', 
                          options_for_select($date, $selected_data)) ?>

                                                   
    <?php echo submit_image_tag('btn-applica.png', array('id' => 'disegni-decreti-filter-apply', 'alt' => 'applica', 'style' => 'display: none;', 'name' => 'disegni-decreti-filter-apply' )) ?>
  </fieldset>
</form>