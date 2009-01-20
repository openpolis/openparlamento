<?php echo use_helper('AdvancedOptionsForSelect') ?>

<?php echo form_tag('#', array("id"=>"disegni-decreti-filter")) ?>
  <fieldset class="labels">
    <label for="filter_group">gruppo:</label>
    <label for="filter_const">circoscrizione:</label>
  </fieldset>
  <p>filtra per</p>
  <fieldset>

    <?php echo select_tag('filter_group', 
                          options_for_select($groups, $selected_group)) ?>
                          
   <?php echo select_tag('filter_const', 
                         options_for_select($constituencies, $selected_const)) ?>
                                                   
    <?php echo submit_image_tag('btn-applica.png', array('id' => 'disegni-decreti-filter-apply', 'alt' => 'applica', 'style' => 'display: none;', 'name' => 'disegni-decreti-filter-apply' )) ?>
  </fieldset>
</form>
