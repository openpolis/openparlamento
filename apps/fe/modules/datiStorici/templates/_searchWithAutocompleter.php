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
        minChars: "2", width: "300px", max: "50", scrollHeight: "250px",
        multiple: true, multipleSeparator: ','
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
	  <?php if (isset($limit)): ?>
  	  <input id="limit" name="limit" value="<?php echo $limit ?>" type="hidden"/>	   
	  <?php endif ?>
    <input id="tag_search" name="tag_search" class="ac_input blur" value="<?php echo $tags?>"/>
    <label for="ramo_C">Camera</label>
    <?php echo radiobutton_tag('ramo', 'C', $ramo == 'C') ?>
    <label for="ramo_S">Senato</label>
    <?php echo radiobutton_tag('ramo', 'S', $ramo == 'S') ?>
    <?php echo submit_image_tag('btn-cerca-small.png', 
                                array('alt' => 'cerca', 'id' => 'aggiungi', 'name' => 'aggiungi')) ?>
	</fieldset>
</form>
      

