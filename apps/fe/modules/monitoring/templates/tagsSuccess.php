<?php echo use_helper('Javascript'); ?>

<?php echo include_component('monitoring', 'submenu', array('current' => 'tags')); ?>

<div id="content" class="tabbed-orange float-container">
  <div id="main">

    <?php if ($sf_flash->has('subscription_promotion')): ?>
      <div class="flash-messages">
        <?php echo $sf_flash->get('subscription_promotion') ?>
      </div>
    <?php endif; ?>
    <?php if (!$sf_user->hasCredential('premium') && !$sf_user->hasCredential('adhoc')): ?>    
    <div style="width:40%; font-size:14px; line-height:1.2em; border:1px solid #EE7F00; padding:5px;" ><strong>Promuovi la trasparenza e la partecipazione!</strong><br /><?php echo link_to('Prenota la tua tessera 2010 all\'associazione openpolis','@tesseramento') ?>
      </div>
      <?php endif; ?>


    <?php if ($opp_user->getNMonitoredTags()>0): ?>
    	<h5 class="subsection">gli argomenti che stai monitorando 
    	  <?php if (!$sf_user->hasCredential('adhoc')): ?>    	   
        	(ancora <span id="my_remaining_tags"><?php echo $remaining_tags ?></span> a disposizione)
    	  <?php endif ?>
    	</h5>
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
              $tag_id=TagPeer::retrieveByTagname($my_tag_name);
              echo link_to(strtolower($value), '@news_tag?id='.$tag_id->getId(), array('class' => 'folk'.($popularity+3))); 
            ?>
            <?php echo link_to('x', '@removeTagFromMyMonitoredTags?name='.$tag, array('class' => 'ico-stop_monitoring', 'title' => 'smetti di monitorare questo argomento')) ?>
          </li>
        <?php endforeach ?>
      </ul>
	  </div>

    <h5 class="subsection">Aggiungi un argomento</h5>

    <?php echo include_partial('deppTagging/addToMonitoredWithAutocompleter', array('name' => 'search_tag')); ?>

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
            <ul id="top_term_tags_<?php echo $term_id;?>" style="display:none"><li> </li></ul>
          </li>
        <?php endforeach ?>
  		</ul>
    </div>

  </div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  i miei argomenti
<?php end_slot() ?>

<!-- slider jQuery per gli atti e le notizie relative -->
<script type="text/javascript">
//<![CDATA[

jQuery.noConflict();
(function($) {
  $().ready(function(){

    $('.topics-list li.top_term a').click(
    	function(){
    	  $this = $(this);
    	  
    		var child = $this.nextAll('ul');
    		var parent = $this.parents('li');
        var url = "<?php echo url_for('monitoring/ajaxTagsForTopTerm'); ?>";
        var id = $(child).get(0).id.split('_').pop();
    		if(child.length) {
          if (!$this.data('tags_loaded'))
          {
            $.get(url, { tt_id: id },
              function(data){
          			parent.toggleClass('opened');
                child.append(data).toggle();
                $this.data('tags_loaded', true);
              }
            );      
          } else {
            parent.toggleClass('closed').toggleClass('opened');
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
