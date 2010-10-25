<div id="tags_associati_for_index">

  <div id="tag_show_for_index" class="tags">
    <?php include_partial('atto/tagsForIndex', array('tags' => $tags)) ?>
    <?php echo image_tag('indicator.gif', array('id'=>'tag_removal_indicator', 'style' => 'display:none')) ?>
  </div> 

  <div id="tag_edit_for_index">
    Cerca tag: 
    <?php echo form_remote_tag(array(
      'update' => 'tag_show_for_index',
      'url' => 'atto/addAjaxTagForIndex?atto_id='. $content->getId(),
      'complete' => "$('tag_search_for_index').value=''; refresh_tags_for_index_show_observers();"), 
      array('id' => 'autocompleter_for_index', 'style' => 'display:inline')); ?>
      <input id="tag_search_for_index" name="tag_search_for_index" class="ac_input" />
      <?php echo submit_tag('Aggiungi', array('id' => 'aggiungi_for_index', 'name'=>'aggiungi_for_index')) ?>
      <?php echo image_tag('indicator.gif', array('id'=>'autocomplete_indicator_for_index', 'style' => 'display:none')) ?>
    </form>

  </div>

</div>  

<script>
jQuery(document).ready(function(){
  var url = "<?php echo url_for('deppTagging/tagsAutocomplete')?>";
  jQuery("#tag_search_for_index").autocomplete(url, {
    formatItem: function(row, i, max) {
			return row[0] + " (" + row[1] + ")";
		},
    formatResult: function(row, i, max) {
			return row[0];
		},    		
    minChars: "2", width: "300px", max: "50", scrollHeight: "250px", multiple: true
  });
});
</script>

<script type="text/javascript" language="javascript">
//<![CDATA[

/**
 * Funzione che assegna observer per eventi dei tag associati
 */
refresh_tags_for_index_show_observers = function(){
  var removers = $$('div#tag_show_for_index div .remover');
  
  removers.each( function(el) {

    // identifica remover e tag
    remover = el;
          
    // click sulla X per rimuovere il tag dai miei tag
    if (remover)
      remover.observe('click', function(event) {
        var elt = Event.element(event);
        remove_tag_for_index(elt.up().id);
      });  
  });
  
};

// assegnazione degli observers ai tag associati
refresh_tags_for_index_show_observers();


// gestione della rimozione di un tag dai tag associati
// TODO: verificare problemi con onCreate e onComplete per l'indicatore
remove_tag_for_index = function(tag_triple){
  var url = "<?php echo url_for('atto/ajaxRemoveTagFromAssociatedTagsForIndex'); ?>?atto_id=<?php echo $content->getId()?>&tag_triple=" + tag_triple;  
  new Ajax.Request(url, { 
    method: 'get', 
    onSuccess: function(transport) { 
      $('tag_show_for_index').update(transport.responseText);
      refresh_tags_for_index_show_observers();
    },
  });

};

//]]>
</script>


