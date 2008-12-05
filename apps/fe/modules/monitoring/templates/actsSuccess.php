<?php echo include_component('monitoring', 'submenu', array('current' => 'acts')); ?>

<div id="content" class="tabbed float-container">
  <div id="main" class="monitored_acts monitoring">

    <?php include_partial('actsFilter',
                          array('tags' => $all_monitored_tags,
                                'types' => $all_monitored_acts_types, 
                                'selected_tag_id' => array_key_exists('tag_id', $filters)?$filters['tag_id']:0,
                                'selected_act_type_id' => array_key_exists('act_type_id', $filters)?$filters['act_type_id']:0,                                
                                'selected_act_ramo' => array_key_exists('act_ramo', $filters)?$filters['act_ramo']:0,
                                'selected_act_stato' => array_key_exists('act_stato', $filters)?$filters['act_stato']:0)) ?>

   
    <div><?php echo link_to('mostra solo preferiti', 'monitoring/favouriteActs') ?></div>
    <div><?php echo link_to('mostra atti <i>bloccati</i>', 'monitoring/blockedActs') ?></div>
    
    <h3>Elenco degli atti monitorati</h3>


    <?php foreach ($monitored_acts_types as $type): ?>
      <?php echo include_component('monitoring', 'actsForType', 
                                   array('user' => $user, 'user_id' => $user_id,
                                         'my_monitored_tags_pks' => $my_monitored_tags_pks,
                                         'type' => $type,
                                         'filters' => $filters,
                                         'tag_filtering_criteria' => $tag_filtering_criteria)); ?>
    <?php endforeach ?>


  </div>
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
  $('.monitored_acts .acts li span.title').click( function(){
    $this = $(this);
    var id = $this.parent().get(0).id.split('_').pop();
    var url = "<?php echo url_for('monitoring/ajaxNewsForAct'); ?>";
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

