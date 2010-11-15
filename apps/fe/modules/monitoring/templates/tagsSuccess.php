<?php echo use_helper('Javascript'); ?>

<?php echo include_component('monitoring', 'submenu', array('current' => 'tags')); ?>

<div id="content" class="tabbed-orange float-container">
  <?php echo include_partial('secondLevelMenuArgomenti', 
                             array('current' => 'overview')); ?>

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

    <div class="float-right" style="width:48%;">
       <?php if ($opp_user->getNMonitoredTags()>0 && 
       ($sf_user=="actionaid" || $sf_user=="verde") ): ?>
        	<h5 class="subsection">Chi si occupa dei miei argomenti</h5>
        	<div style="padding:5px; font-size:14px;">
        	  <?php if ($sf_user=="actionaid") :?>
        	   <?php echo link_to("Classifica dei deputati","/argomenti_actionaid/C")?><br/><br/>
        	   <?php echo link_to("Classifica dei senatori","/argomenti_actionaid/S")?>
        	  <?php endif ?>  
        	  <?php if ($sf_user=="verde") :?>
        	   <?php echo link_to("Classifica dei deputati","/argomenti_enel/C")?><br/><br/>
        	   <?php echo link_to("Classifica dei senatori","/argomenti_enel/S")?>
        	  <?php endif ?>
        	  </div>
        <?php endif ?>	
    </div>  

    <?php include_partial('monitoring/tagsMonitoredByUser', 
                          array('opp_user' => $opp_user, 'sf_user' => $sf_user, 
                                'my_tags' => $my_tags, 'remaining_tags' => $remaining_tags)) ?>

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
