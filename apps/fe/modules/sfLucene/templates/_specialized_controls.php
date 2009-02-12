<?php echo form_tag("@attiSearch?type=$type", array('method' => 'get', 'id' => 'search-ddl')) ?>
  <h6><?php echo $title?></h6>
  <fieldset id="search-ddl-fbox">
    <?php echo input_tag('query', $query, 
                         array('id' => 'search-ddl-field', 
                               'name' => 'query', 
                               'tabindex' => '1', 
                               'accesskey' => 'q',
                               'class' => 'blur') ) ?>
    <?php echo submit_image_tag('btn-cerca-small.png', 
                                array('id' => 'search-ddl-go', 
                                      'alt' => 'cerca', 
                                      'name' => 'search-go',
                                      'accesskey' => 's' )) ?>	
  </fieldset>
</form>
