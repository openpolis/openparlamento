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



<!-- slider jQuery per gli atti e le notizie relative -->
<script type="text/javascript" language="javascript">
//<![CDATA[

jQuery.noConflict();
(function($){
  
  // acts slider
  $('.type').click( function(){
    var id = $(this).get(0).id.split('_').pop();
    $(this).parent().find("#type_acts_" + id).slideToggle("slow");
  });
  
  // news cached-slider (only does ajax request once)
  $('#monitored_acts .acts li span.title').click( function(){
    $this = $(this);
    var id = $this.parent().get(0).id.split('_').pop();
    var url = "<?php echo url_for('monitoring/ajaxNewsForAct'); ?>";
    var news = $('monitored_acts .acts li#' + id + ' div.news');
    if (!$this.data('news_loaded'))
    {
      $.get(url, { act_id: id },
        function(data){
          $this.parent().append('<div class="news">' + data + '</div>').css('display', 'none').slideDown();
          $this.data('news_loaded', true);
          $this.unbind('click').click( function(){
            $(this).parent().find("div.news").slideToggle("slow");
          });
        })      
    }
      
  });  
})(jQuery);


//]]>
</script>

