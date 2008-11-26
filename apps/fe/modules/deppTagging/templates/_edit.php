<?php echo use_helper('Javascript', 'Tags') ?>
<div id="tag_associati" style="margin: 20px 0">

  Tag associati:
  <div id="tag_show">
    <?php foreach ($tags as $tag): ?>
      <div id="<?php echo $tag[0]?>" class="<?php echo get_classes_for_tag($tag[3], $teseo_tags, $user_tags, $my_tags) ?>">
        <?php if (is_removable($tag[3], $removable_tags)): ?>
          <span class="remover" title="clicca qui per rimuovere questo tag">(X)</span>
        <?php endif ?>
        <span class="tag"><?php echo link_to(strtolower($tag[3]), '@tag?tag_name='.$tag[0])?></span>
      </div> &nbsp;
    <?php endforeach ?>
    <?php echo image_tag('indicator.gif', array('id'=>'tag_removal_indicator', 'style' => 'display:none')) ?>
  </div>

  <?php if ($anonymous_tagging || $sf_user->isAuthenticated()): ?>
    <div id="tag_edit">
      Aggiungi tag: 
      <?php echo form_remote_tag(array(
          'update' => 'tag_show',
          'complete' => "$('usertags_autocomplete').value=''; refresh_tags_show_observers();",
          'url'    => "deppTagging/addAjax?content_type=" .get_class($content). "&content_id=". $content->getId()
          ), array('style' => 'display:inline')); ?>
        <input type="text" id="usertags_autocomplete" name="usertags" 
               autocomplete="off" value="" size="30"/>
        <?php echo submit_tag('Salva') ?>
        <div id="autocomplete_choices" class="autocomplete"></div>
      </form>
      <?php echo image_tag('indicator.gif', array('id'=>'autocomplete_indicator', 'style' => 'display:none')) ?>
    </div>
  <?php endif ?>  

</div>  


<?php if ($anonymous_tagging || $sf_user->isAuthenticated()): ?>

  <!-- script per la gestione dell'autocompleter -->
  <script type="text/javascript" language="javascript">
  //<![CDATA[
  new Ajax.Autocompleter("usertags_autocomplete", "autocomplete_choices",
                         "<?php echo url_for('deppTagging/usertagsAutocomplete')?>", 
    {
      paramName: "value",
      indicator: "autocomplete_indicator",
      frequency: 0.3,
      tokens: [','],
      updateElement: function (le) { 
        var val = $('usertags_autocomplete').value;
        $('usertags_autocomplete').value =  (val.lastIndexOf(',') > 0 ? val.truncate(2+val.lastIndexOf(','), '') : '') + le.innerHTML.unescapeHTML().strip();
      }
    });

  //]]>
  </script>

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
