<?php echo include_component('monitoring', 'submenu', array('current' => 'acts')); ?>

<div id="content" class="tabbed float-container">
  <div id="main" class="monitored_acts monitoring">

    <div><?php echo link_to('mostra l\'elenco completo', 'monitoring/acts') ?></div>
    
    <h3>Elenco degli atti preferiti</h3>

    <div class="acts">
      <ul>
        <?php foreach ($favourite_acts as $act): ?>
          <?php  echo include_component('monitoring', 'actLine', 
                                       array('act' => $act, 'user' => $user, 'user_id' => $user_id)); ?>
        <?php endforeach ?>        
      </ul>
    </div>

  </div>
</div>

<!-- slider jQuery per gli atti e le notizie relative -->
<script type="text/javascript" language="javascript">
//<![CDATA[

jQuery.noConflict();
(function($){
  
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
