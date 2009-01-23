<?php echo use_helper('Javascript'); ?>

<?php echo include_component('monitoring', 'submenu', array('current' => 'tags')); ?>

<div id="content" class="tabbed-orange float-container">
  <div id="main">

    <?php if ($opp_user->getNMonitoredTags()>0): ?>
    	<h5 class="subsection">gli argomenti che stai monitorando (ancora <span id="my_remaining_tags"><?php echo $remaining_tags ?></span> a disposizione)</h5>
    <?php else: ?>
      Non stai monitorando nessun argomento
    <?php endif ?>

    <div class="more-results float-container">
      <ul id="my_tags" class="monitoring-list">
        <li id="ok" style="display:none"><?php echo $remaining_tags ?></li>
        <?php foreach ($my_tags as $my_tag_name => $popularity): ?>
          <li title="click per visualizzare le notizie relative">
            <?php 
              list($tag, $ns, $key, $value) = deppPropelActAsTaggableToolkit::extractTriple($my_tag_name);
              echo link_to(strtolower($value), '@news_tag?name='.$tag, array('class' => 'folk'.($popularity+3))); 
            ?>
            <?php echo link_to('x', '@removeTagFromMyMonitoredTags?name='.$tag, array('class' => 'ico-stop_monitoring', 'title' => 'smetti di monitorare questo argomento')) ?>
          </li>
        <?php endforeach ?>
      </ul>
	  </div>

    <h5 class="subsection">Aggiungi un argomento</h3>

    <?php if ($opp_user->getNMaxMonitoredTags() - $opp_user->getNMonitoredTags() > 0): ?>
      <div class="W25_100 float-right">
        <?php echo include_partial('deppTagging/addToMonitoredWithAutocompleter', array()); ?>
      </div>
    <?php endif ?>

    <div id="top_terms_drill_down" class="W73_100 float-left">
      <ul class="topics-list">
        <?php foreach ($teseo_tts_with_counts as $term_id => $term_data ): ?>
          <li id="top_term_<?php echo $term_id;?>" class="top_term">
            <?php echo link_to($term_data['denominazione'] .  " (" . $term_data['counter'] .  ")", '#') ?>
            <?php if ($term_data['n_monitored']>0): ?>
              <span class="ico-monitoring-left">(
                <?php echo $term_data['n_monitored'] ?>
              )</span>              
            <?php endif ?>
            <ul id="top_term_tags_<?php echo $term_id;?>" style="display:none"></ul>
          </li>
        <?php endforeach ?>
  		</ul>
    </div>

  </div>
</div>

<!-- slider jQuery per gli atti e le notizie relative -->
<script type="text/javascript">
//<![CDATA[

jQuery.noConflict();
(function($) {
  $(document).ready(function(){
  
    $('.topics-list li.top_term a').click(
    	function(){
    	  $this = $(this);
    	  
    		var child = $this.nextAll('ul');
        var url = "<?php echo url_for('monitoring/ajaxTagsForTopTerm'); ?>";
        var id = $(child).get(0).id.split('_').pop();
    		if(child.length) {
          if (!$this.data('tags_loaded'))
          {
            $.get(url, { tt_id: id },
              function(data){
          			$this.toggleClass('opened');
                child.append(data).toggle();
                $this.data('tags_loaded', true);
                /*
                child.find('li').click(
                  function(){
                    var $this = $(this);
                    var wasMonitoring = $this.hasClass('monitoring');                    
                    var id = $this.get(0).id.split('_').last();
                    var my_tags = $('#my_tags');
                    if (!wasMonitoring) {
                      var url = "<?php echo url_for('monitoring/ajaxAddTagIdToMyMonitoredTags'); ?>";
                      var title = 'click per rimuovere dai tuoi tag';
                    } else {
                      var url = "<?php echo url_for('monitoring/ajaxRemoveTagIdFromMyMonitoredTags'); ?>";                        
                      var title = 'click per aggiungere ai tuoi tag';
                    } 
                    $.get(url, {tag_id: id},
                      function(data){
                        if (data.match(/ok/))
                        {
                          $this.toggleClass('monitoring');
                          $this[0].title = title;
                          my_tags.replaceWith(data);
                          var remaining_tags = data.match(/<li id="ok".*>(.*)<\/li>/)[1];
                          $('#my_remaining_tags').html(remaining_tags);
                        }
                        else
                        {
                          alert(data);
                        } 
                        
                      }
                    );
                  }
                );
                */
              }
            );      
          } else {
            $this.toggleClass('closed').toggleClass('opened');
      			child.toggle();
          }
    		}
    		return false;    	    
    	}
    );
    

  })
})(jQuery);

//]]>
</script>
