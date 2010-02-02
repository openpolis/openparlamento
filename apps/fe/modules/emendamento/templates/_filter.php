<?php echo use_helper('AdvancedOptionsForSelect') ?>


<?php echo form_tag('#', array("id"=>"disegni-decreti-filter", "class" => $active?'active':'')) ?>
  <fieldset class="labels">
    <label for="filter_article">articolo:</label>
    <label for="filter_site">sede:</label>
    <label for="filter_presenter">presentatore:</label>
    <label for="filter_status">status:</label>
  </fieldset>
  <p>filtra per</p>
  <fieldset>
    <?php echo select_tag('filter_article', 
                          options_for_select($available_articles, $selected_article)) ?>
                          
    <?php echo select_tag('filter_site', 
                          options_for_select($available_sites, $selected_site)) ?>

    <?php echo select_tag('filter_presenter', 
                          options_for_select($available_presenters, $selected_presenter)) ?>

    <?php echo select_tag('filter_status', 
                          options_for_select($available_statuses, $selected_status)) ?>

    <?php echo submit_image_tag('btn-applica.png', array('id' => 'disegni-decreti-filter-apply', 'alt' => 'applica', 'style' => 'display: none;', 'name' => 'disegni-decreti-filter-apply' )) ?>
  </fieldset>
</form>