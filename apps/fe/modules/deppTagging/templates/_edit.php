<script>
jQuery(document).ready(function(){
  var url = "<?php echo url_for('deppTagging/tagsAutocomplete')?>";
  jQuery("#tag_search").autocomplete(url, {
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

<?php echo use_helper('Javascript', 'Tags') ?>
<div id="tag_associati" style="margin: 20px 0">

  <div id="tag_show" class="tags">
    <em>argomenti:</em>
    <?php foreach ($tags as $tag): ?>
      <div id="<?php echo $tag[0]?>" class="<?php echo get_classes_for_tag($tag[3], $teseo_tags, $user_tags, $my_tags) ?>">
        <?php if ($sf_user->hasCredential('administrator')): ?>
          <span class="remover" title="clicca qui per rimuovere questo tag">(X)</span>        
        <?php endif ?>
        <span class="tag"><?php echo link_to(strtolower($tag[3]), '@tag?tag_name='.$tag[0])?></span>
      </div> &nbsp;
    <?php endforeach ?>
    <?php echo image_tag('indicator.gif', array('id'=>'tag_removal_indicator', 'style' => 'display:none')) ?>
  </div>

  <?php if ($sf_user->hasCredential('administrator')): ?>
    <div id="tag_edit">
      Cerca tag: 
      <?php echo form_remote_tag(array(
        'update' => 'tag_show',
        'url' => 'deppTagging/addAjax?content_type='. get_class($content) . "&content_id=" . $content->getId(),
        'complete' => "$('tag_search').value=''; refresh_tags_show_observers();"), 
        array('id' => 'autocompleter', 'style' => 'display:inline')); ?>
        <input id="tag_search" name="tag_search" class="ac_input" />
        <?php echo submit_tag('Aggiungi', array('id' => 'aggiungi', 'name'=>'aggiungi')) ?>
        <?php echo image_tag('indicator.gif', array('id'=>'autocomplete_indicator', 'style' => 'display:none')) ?>
      </form>
    </div>
  <?php endif ?>  

</div>  


<?php if ($anonymous_tagging || $sf_user->isAuthenticated()): ?>

  <script type="text/javascript" language="javascript">
  //<![CDATA[
 
  /**
   * Funzione che assegna observer per eventi dei tag associati
   */
  refresh_tags_show_observers = function(){
    var tags = $$('div#tag_show div');
    tags.each( function(el) {

      // identifica remover e tag
      remover = el.select('span[class="remover"]')[0];

      // click sulla X per rimuovere il tag dai miei tag
      if (remover)
        remover.observe('click', function(event) {
          var elt = Event.element(event);
          remove_tag(elt.up().id);
        });  
    });
    
  };
 
  // assegnazione degli observers ai tag associati
  refresh_tags_show_observers();
  
  // gestione della rimozione di un tag dai tag associati
  // TODO: verificare problemi con onCreate e onComplete per l'indicatore
  remove_tag = function(tag_name){
    var url = "<?php echo url_for('deppTagging/ajaxRemoveTagFromAssociatedTags'); ?>?content_type=<?php echo get_class($content)?>&content_id=<?php echo $content->getId()?>&tag_name=" + tag_name;  
    new Ajax.Request(url, { 
      method: 'get', 
      onSuccess: function(transport) { 
        $('tag_show').update(transport.responseText);
        refresh_tags_show_observers();
      },
    });

  };
  
  //]]>
  </script>


<?php endif ?>  
