<?php echo use_helper('AdvancedOptionsForSelect') ?>


<?php echo form_tag('#', array("id"=>"disegni-decreti-filter", "class" => $active?'active':'')) ?>
  <fieldset class="labels">
    <label for="filter_ddls_collegati">ddl di riferimento:</label>
  </fieldset> 
  <p>filtra per</p>
  <fieldset>
    
    <?php echo select_tag('filter_ddls_collegati', 
                          adv_objects_for_select($ddls_collegati, 'getId', 'getRamoNumfase', $selected_ddls_collegati, 
                                                 'include_zero_custom=tutti')) ?>
                                                   
    <?php echo submit_image_tag('btn-applica.png', array('id' => 'disegni-decreti-filter-apply', 'alt' => 'applica', 'style' => 'display: none;', 'name' => 'disegni-decreti-filter-apply' )) ?>
  </fieldset>
</form>