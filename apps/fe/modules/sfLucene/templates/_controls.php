
<?php echo form_tag('sfLucene/search', array('method' => 'get', 'id' => 'search-main')) ?>
  <p>
    <?php echo input_tag('query', $query, 
                         array('id' => 'search-main-field', 
                               'name' => 'query', 
                               'tabindex' => '1', 
                               'accesskey' => 'q') ) ?>
    <?php echo submit_image_tag('btn-cerca.png', 
                                array('id' => 'search-main-go', 
                                      'alt' => 'cerca', 
                                      'name' => 'search-go',
                                      'accesskey' => 's' )) ?>	
  </p>
</form>