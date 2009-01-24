<script>
jQuery.noConflict();
(function($) {
    $(document).ready(function(){
      var url = "<?php echo url_for('deppTagging/tagsAutocomplete')?>";
      $("#tag_search").autocomplete(url, {
        formatItem: function(row, i, max) {
    			return row[0] + " (" + row[1] + ")";
    		},
        formatResult: function(row, i, max) {
    			return row[0];
    		},    		
        minChars: "2", width: "300px", max: "50", scrollHeight: "250px"
      }).result(function(event, data) {
         $("#name").get(0).value =  !data ? "No match!" :  data[2];
      });
    });
  })(jQuery);
</script>
<div id="tag_add">
  Cerca tag: 
  <?php echo form_tag('monitoring/addTagToMyMonitoredTags', array('id' => 'autocompleter', 'style' => 'display:inline')); ?>
    <input id="tag_search" class="ac_input" />
    <input id="name" name="name" type="hidden"/>
    <?php echo submit_tag('Aggiungi', array('id' => 'aggiungi', 'name'=>'aggiungi')) ?>
  </form>
</div>      
      

