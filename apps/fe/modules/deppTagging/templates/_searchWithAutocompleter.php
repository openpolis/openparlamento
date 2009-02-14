<script>
jQuery.noConflict();
(function($) {
    $(document).ready(function(){
      var url = "<?php echo url_for('deppTagging/tagsAutocomplete')?>";
      $("#tag_search").autocomplete(url, {
        formatItem: function(row, i, max) {
          r = row[0];
          if (row[1] != '') r += " (" + row[1] + ")";
    			return r;
    		},
        formatResult: function(row, i, max) {
    			return row[0];
    		},    		
        minChars: "2", width: "300px", max: "50", scrollHeight: "250px"
      }).result(function(event, data) {
         $("#tag_name").get(0).value =  !data ? "No match!" :  data[2];
      });
    });
  })(jQuery);
</script>
<div class="W50_100">
<h5 class="subsection">Cerca tra gli argomenti ...</h5>
  <?php echo form_tag('argomento_search', array('id' => 'search-autocompleter')); ?>
		
		<fieldset id="search-autocompleter-fbox">
      <input id="tag_search" class="ac_input blur"/>
      <input id="tag_name" name="tag_name" type="hidden"/>
      <?php echo submit_image_tag('btn-cerca-small.png', 
                                  array('alt' => 'cerca', 'id' => 'aggiungi', 'name' => 'aggiungi')) ?>
		</fieldset>
	</form>
</div>
      

