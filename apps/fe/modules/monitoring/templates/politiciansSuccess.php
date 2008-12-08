<?php echo use_helper('I18N'); ?>

<?php echo include_component('monitoring', 'submenu', array('current' => 'politicians')); ?>

<div id="content" class="tabbed float-container">
  <div id="main" class="monitored_acts monitoring">

    <h3>I politici che stai monitorando</h3>
  
    <?php foreach ($monitored_politicians as $politician): ?>
      <div id="pol_<?php echo $politician->getId();?>">
        <div class="politician">
          <span class="name"><?php echo $politician; ?></span>
          <span class="info">
            <?php echo format_number_choice( 
              '[0]|[1]1 nuova|(1,+Inf]%1% nuove', 
              array('%1%' => $politician->getNNewNews($sf_user->getAttribute('last_login', null, 'subscriber'))),
              $politician->getNNewNews($sf_user->getAttribute('last_login', null, 'subscriber'))) 
            ?> 
            - ultima: <?php echo $politician->getLastNews()->getDate('d/m/Y h:i') ?> - 
          </span>
          <span>
          <?php echo link_to('rimuovi dal monitoraggio',                                        
                             'monitoring/removeItemFromMyMonitoredItems?item_model=OppPolitico&item_pk=' .
                             $politician->getPrimaryKey()) ?>
          </span>
        </div>
      </div>
    <?php endforeach ?>
    
  </div>
</div>
<!-- slider jQuery per le notizie relative ai politici -->
<script type="text/javascript" language="javascript">
//<![CDATA[

jQuery.noConflict();
(function($){
  
  // news cached-slider (only does ajax request once)
  $('.monitored_acts .politician span.name').click( function(){
    $this = $(this);
    var id = $this.parent().parent().get(0).id.split('_').pop();
    var url = "<?php echo url_for('monitoring/ajaxNewsForPolitician'); ?>";
    if (!$this.data('news_loaded'))
    {
      $.get(url, { politician_id: id },
        function(data){
          $this.parent().parent().append('<div class="news">' + data + '</div>').css('display', 'none').slideDown();
          $this.data('news_loaded', true);
          $this.unbind('click').click( function(){
            $(this).parent().parent().find("div.news").slideToggle("slow");
          });
        })      
    }
      
  });  
})(jQuery);


//]]>
</script>
