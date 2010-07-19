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
      $("#tag_search").focus(function(){
        if(this.value == this.defaultValue)
        {
          this.select();
        }
      });
    });
  })(jQuery);
</script>

<h5 class="subsection">Cerca tra i <?php echo count($tag_count) ?> argomenti ...</h5>
<?php echo form_tag('datiStorici/interessi', array('id' => 'search-autocompleter')); ?>
	
	<fieldset id="search-autocompleter-fbox">
    <input id="tag_search" class="ac_input blur" value="<?php echo $argomento?$argomento->getTripleValue():''?>"/>
    <label for="ramo_C">Camera</label>
    <?php echo radiobutton_tag('ramo', 'C', $ramo == 'C') ?>
    <label for="ramo_S">Senato</label>
    <?php echo radiobutton_tag('ramo', 'S', $ramo == 'S') ?>
    <input id="tag_name" name="tag_name" type="hidden" value="<?php echo $argomento->getName()?>"/>
    <?php echo submit_image_tag('btn-cerca-small.png', 
                                array('alt' => 'cerca', 'id' => 'aggiungi', 'name' => 'aggiungi')) ?>
	</fieldset>
</form>
      

