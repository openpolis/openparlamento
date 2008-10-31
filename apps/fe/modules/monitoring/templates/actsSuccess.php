<?php echo include_component('monitoring', 'submenu', array('current' => 'acts')); ?>


<div id="monitored_acts">
  <h2>Elenco degli atti monitorati</h2>
  
  <?php if ($tag_filtering_criteria): ?>
    &Egrave; attivo il filtro sul tag <?php echo $tag_filter->getTripleValue() ?>. <?php echo link_to('Rimuovi il filtro', 'monitoring/acts') ?>
  <?php endif ?>

  <?php foreach ($monitored_acts_types as $type): ?>
    <h3 id="type_<?php echo $type->getId();?>" class="type">Atti di tipo <?php echo $type->getDenominazione(); ?></h3>
    <div id="type_acts_<?php echo $type->getId();?>" class="acts">
      <?php echo include_component('monitoring', 'actsForType', 
                                   array('type_id' => $type->getId(), 
                                         'tag_filtering_criteria' => $tag_filtering_criteria)); ?>
    </div>
  <?php endforeach ?>
</div>

<script type="text/javascript" language="javascript">
//<![CDATA[

// assegnazione degli observer corretti ai top term
var top_terms = $$('.type');
top_terms.each( function(el) {
  el.observe('click', function(event) {
    var elt = Event.element(event);
    cached_drill_down(elt);
  })  
});


//  script per la gestione del drill down dei top terms 
//  il drill down è cached, nel senso che, se non viene trovato, allora
//  è richiesto via ajax al server, altrimenti viene chiuso o aperto
cached_drill_down = function(el){
  var id = el.id.split('_').last();
  var acts_ul = $$('#type_acts_' + id + ' ul');
  var acts = $('type_acts_' + id);
  if (acts_ul == '')
  {
    var url = "<?php echo url_for('monitoring/ajaxActsForType'); ?>?type_id=" + id;
    new Ajax.Updater($('type_acts_' + id), url, {
      evalScripts: true,
      // onComplete: setTimeout('refresh_tags_container(\'top_term_tags_'+id+'\')', 500)
    });
    acts.style.display = 'block';
  } else {
    if (acts.style.display == 'none')
      acts.style.display = 'block';
    else
      acts.style.display = 'none';
  }
};



//]]>
</script>

