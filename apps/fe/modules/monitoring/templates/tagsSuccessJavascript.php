<script type="text/javascript" language="javascript">
//<![CDATA[

// assegnazione degli observer corretti ai top term
var top_terms = $$('.top_term');
top_terms.each( function(el) {
  el.observe('click', function(event) {
    var elt = Event.element(event);
    cached_drill_down(elt);
  })  
});

/**
 * Assegna observer per eventi dei my_tags
 */
refresh_mytags_observers = function(){
  var lis = $$('#my_tags li');
  lis.each( function(el) {
    // per l'elemento nascosto, skip 
    if (el.descendants().length == 0) return;
    
    // mouseover e mouseout su elemento, mostrano la X della rimozione
    el.observe('mouseover', function(event) {
      el.firstDescendant().style.display = 'inline';
    });
    el.observe('mouseout', function(event) {
      el.firstDescendant().style.display = 'none';
    });

    // identifica remover e tag
    remover = el.firstDescendant();
    tag = remover.next();

    // click sulla X per rimuovere il tag dai miei tag
    remover.observe('click', function(event) {
      var elt = Event.element(event);
      unselect_tag(elt.up());
      var id = elt.up().id.split('_').last();
      removed = $('tag_'+id);
      if (removed !== null)
      {
        removed.className = '';
        removed.title = 'click per aggiungere ai tuoi tag';
      }
      
    });  
  });
};

// eventuale assegnazione degli observers ai miei tag
refresh_mytags_observers();


//  script per la gestione del drill down dei top terms 
//  il drill down è cached, nel senso che, se non viene trovato, allora
//  è richiesto via ajax al server, altrimenti viene chiuso o aperto
cached_drill_down = function(el){
  var id = el.id.split('_').last()
  var tags_ul = $$('#top_term_tags_' + id + ' ul');
  var tags = $('top_term_tags_' + id);
  if (tags_ul == '')
  {
    var url = "<?php echo url_for('monitoring/ajaxTagsForTopTerm'); ?>?tt_id=" + id;
    new Ajax.Updater($('top_term_tags_' + id), url, {
      evalScripts: true,
      onComplete: setTimeout('refresh_tags_container(\'top_term_tags_'+id+'\')', 500)
    });
    
  } else {
    if (tags.style.display == 'none')
      tags.style.display = 'block';
    else
      tags.style.display = 'none';
  }
};


// funzione che aggiunge ai tag gli observer adatti
refresh_tags_container = function(container_id){
  var tags_container = $(container_id);
  tags_container.style.display = 'block'; 

  var tags = $$('#'+container_id + '.tags li');
  tags.each( function(el) {
    el.observe('click', function(event) {
      var elt = Event.element(event);
      if (elt.className != 'selected')
        select_tag(elt);
      else 
        unselect_tag(elt);
    })  
  });
};


// gestione della selezione di un tag
select_tag = function(el){
  var id = el.id.split('_').last()
  var url = "<?php echo url_for('monitoring/ajaxAddTagIdToMyMonitoredTags'); ?>?tag_id=" + id;  
  new Ajax.Request(url, { 
    method: 'get', 
    onSuccess: function(transport) { 
      if (transport.responseText.match(/ok/))
      {
        el.className = 'selected';
        el.title = 'click per rimuovere dai tuoi tag';
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
};

// gestione della rimozione della selezione di un tag
unselect_tag = function(el){
  var id = el.id.split('_').last()
  var url = "<?php echo url_for('monitoring/ajaxRemoveTagFromMyMonitoredTags'); ?>?tag_id=" + id;  
  new Ajax.Request(url, { 
    method: 'get', 
    onSuccess: function(transport) { 
      if (transport.responseText.match(/ok/))
      {
        el.className = '';
        el.title = 'click per aggiungere ai tuoi tag';
        $('my_tags').update(transport.responseText);
        refresh_mytags_observers();
        $('my_remaining_tags').innerHTML = $('ok').innerHTML;
      }
      else
      {
        alert(transport.responseText);
      } 
    },
  }); 
  
};

//]]>
</script>


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

