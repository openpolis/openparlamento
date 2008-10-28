<?php echo use_helper('Javascript'); ?>


<h2>I tuoi tag</h2>
<ul id="my_tags">
  <li id="ok" style="display:none"></li>
  <?php foreach ($my_tags as $my_tag): ?>
    <li id="my_tag_<?php echo $my_tag->getId()?>" title="click per visualizzare le notizie relative">
      <span class="remover" title="clicca qui per rimuovere questo tag dai tuoi tag">(X)</span>
      <span class="tag" title="clicca qui per visualizzare le notizie relative"><?php echo $my_tag->getTripleValue() ?></span>
    </li>
  <?php endforeach ?>
</ul>


<h2>Elenco dei top-term</h2>
<div id="top_terms_drill_down">
  <?php foreach ($teseo_tts as $top_term): ?>
    <div id="top_term_<?php echo $top_term->getId();?>" class="top_term">
      <?php echo $top_term->getDenominazione() ?>
    </div>
    <div id="top_term_tags_<?php echo $top_term->getId();?>" class="tags" style="display:none"></div>
  <?php endforeach ?>
</div>

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


refresh_mytags_observers = function(){
  var lis = $$('#my_tags li');
  lis.each( function(el) {
    if (el.descendants().length == 0) return;
    remover = el.firstDescendant();
    tag = remover.next();
    tag.observe('click', function(event) {
      var elt = Event.element(event);
      alert('Notizie presto!');
    });  
    el.observe('mouseover', function(event) {
      el.firstDescendant().style.display = 'inline';
    });
    el.observe('mouseout', function(event) {
      el.firstDescendant().style.display = 'none';
    });
    remover.observe('click', function(event) {
      var elt = Event.element(event);
      unselect_tag(elt.up());
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
      onComplete: setTimeout('refresh_tags_container(\'top_term_tags_'+id+'\')', 300)
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
  var url = "<?php echo url_for('monitoring/ajaxAddTagToMyMonitoredTags'); ?>?tag_id=" + id;  
  new Ajax.Request(url, { 
    method: 'get', 
    onSuccess: function(transport) { 
      if (transport.responseText.match(/ok/))
      {
        el.className = 'selected';
        el.title = 'click per rimuovere dai tuoi tag';
        $('my_tags').update(transport.responseText);
      }
      else
      {
        alert(transport.responseText);
      } 
    }, 
    onComplete: setTimeout('refresh_mytags_observers()', 500)
    
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
        setTimeout('refresh_mytags_observers()', 1000);
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

