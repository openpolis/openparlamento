 <?php echo use_helper('Javascript') ?>


<div id="tag_associati" style="margin-bottom: 20px">
  
  Tag associati:
  <div id="tag_show" <?php if ($anonymous_tagging || $sf_user->isAuthenticated()): ?>title="modifica questi tag" style="cursor: pointer; display:inline"<?php else: ?>style="display:inline"<?php endif; ?>>
    <span id="tags"><?php echo $visible_tags_as_string != '' ? $visible_tags_as_string : 'nessuno' ?></span>
    <?php if ($anonymous_tagging || $sf_user->isAuthenticated()): ?>
      <?php echo image_tag('edit.png', array('alt' => 'edit', 'title' => 'modifica questi tag')) ?>      
    <?php endif ?>
  </div>

  <?php if ($anonymous_tagging || $sf_user->isAuthenticated()): ?>
    <div id="tag_edit" style="display:none">
      <?php echo form_remote_tag(array(
          'update' => 'tags',
          'url'    => "deppTagging/editAjax?content_type=" .get_class($content). "&content_id=". $content->getId(),
          'complete' => "$('tag_show').setStyle('display:inline'); $('tag_edit').setStyle('display:none'); $('editable_tags_autocomplete').value = get_editable_tags($('tags')); if ($('tags').innerHTML.strip() == '') $('tags').innerHTML = 'nessuno'; "
          ), array('style' => 'display:inline')); ?>
        <input type="text" id="editable_tags_autocomplete" name="usertags" 
               autocomplete="off" value="<?php echo $editable_tags_as_string ?>" size="50"/>
        <?php echo submit_tag('Salva') ?>
        <div id="autocomplete_choices" class="autocomplete"></div>
      </form>
    </div>
  <?php endif ?>  

</div>


<?php if ($anonymous_tagging || $sf_user->isAuthenticated()): ?>
  <!-- script per la gestione dell'autocomplete -->
  <script type="text/javascript" language="javascript">
  //<![CDATA[
  new Ajax.Autocompleter("editable_tags_autocomplete", "autocomplete_choices",
                         "<?php echo url_for('deppTagging/editableTagsAutocomplete')?>", {
    paramName: "value",
    minChars: 1,
    tokens: [','],
    updateElement: function (le) { 
      var val = $('editable_tags_autocomplete').value;
      $('editable_tags_autocomplete').value =  (val.lastIndexOf(',') > 0 ? val.truncate(2+val.lastIndexOf(','), '') : '') + le.innerHTML.unescapeHTML().strip();
    }
  });

  //]]>
  </script>


  <!-- script per la gestione dell'edit-in-place dei tag associati -->
  <script type="text/javascript" language="javascript">
  //<![CDATA[
  $('tag_show').observe('mouseover',  function (event) { 
    var elt = Event.findElement(event, 'div');
    new Effect.Morph(elt, {
      style: {
        background: '#ffff99'
      }, // CSS Properties
      duration: 0.8 // Core Effect properties
    });
  });  
  $('tag_show').observe('mouseout',  function (event) { 
    var elt = Event.findElement(event, 'div');
    new Effect.Morph(elt, {
      style: {
        background: '#ffffff'
      }, // CSS Properties
      duration: 0.8 // Core Effect properties
    });
  });  

  $('tag_show').observe('click',  function (event) { 
    $('tag_show').setStyle('display:none');
    $('tag_edit').setStyle('display:inline');
    $('editable_tags_autocomplete').focus();
  });  

  //]]>
  </script>

  <!-- script that extracts editable tags out of all associated tags -->
  <script type="text/javascript" language="javascript">
  //<![CDATA[
  function get_editable_tags(el) {
    <?php if ($anonymous_tagging): ?>
      return el.innerHTML().strip_tags();
    <?php else: ?>
      <?php if($allows_tagging_removal == 'all' ||
               $sf_user->hasCredential($tagging_removal_credentials, false)): ?>
        editable_tags = el.select('[class="user"]', '[class="other"]');
      <?php else: ?>
        editable_tags = el.select('[class="user"]');
      <?php endif; ?>
      return editable_tags.innerHTML().strip_tags();
    <?php endif; ?>
  }  
  //]]>
  </script>

<?php endif ?>  
