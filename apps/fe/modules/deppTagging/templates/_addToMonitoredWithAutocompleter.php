<div id="tag_add">
  Cerca tag: 
  <?php echo form_tag('#', array('id' => 'autocompleter', 'style' => 'display:inline')); ?>
    <input style="border:1px solid gray;" type="text" id="tags_autocomplete" name="tags" 
           autocomplete="off" value="" size="30"/>
    <?php echo submit_tag('Aggiungi', array('id' => 'aggiungi', 'name'=>'aggiungi', 'onClick' => 'return false;')) ?>
    <div id="autocomplete_choices" class="autocomplete"></div>
  </form>
  <?php echo image_tag('indicator.gif', array('id'=>'autocomplete_indicator', 'style' => 'display:none')) ?>
</div>      
      
<!-- script per la gestione dell'autocompleter -->
<script type="text/javascript" language="javascript">

//<![CDATA[
new Ajax.Autocompleter("tags_autocomplete", "autocomplete_choices",
                       "<?php echo url_for('deppTagging/tagsAutocomplete')?>", 
  {
    paramName: "value",
    indicator: "autocomplete_indicator",
    frequency: 0.3,
    updateElement: function (le) { 
      var val = le.innerHTML.unescapeHTML();
      if (val.indexOf('\n', 1) != -1) val = val.substring(0, val.indexOf('\n', 1)).strip();
      $('tags_autocomplete').value =  val;
    }
  });
  
$('aggiungi').observe('click', function(event){
  var elt = Event.element(event);
  var form = $('autocompleter');
  var tag = form['tags_autocomplete'];
  var tag_value = $F(tag)
  var url = "<?php echo url_for('monitoring/ajaxAddTagValueToMyMonitoredTags'); ?>?tag_value=" + tag_value;
  new Ajax.Request(url, { 
    method: 'get', 
    onSuccess: function(transport) { 
      if (transport.responseText.match(/ok/))
      {
        $('my_tags').update(transport.responseText);
        refresh_mytags_observers();
        $('my_remaining_tags').innerHTML = $('ok').innerHTML;
      }
      else
      {
        alert(transport.responseText);
      } 
    }
  });
});
//]]>
</script>

