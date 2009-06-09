<?php echo use_helper('Javascript'); ?>

<ul id="content-tabs" class="float-container tools-container">
  <li class="current">
    <h2>
      Argomenti
    </h2> 
  </li>
</ul>

<div id="content" class="tabbed float-container">
  <div id="main">
  <div class="intro-box">
  <p>In questa pagina trovi i <strong><?php echo count($tag_count) ?></strong> argomenti presenti su openparlamento.<br />
  Per trovarne uno puoi cercarlo per <em class="open">parola chiave</em> o navigare le <em class="open"><?php echo count($teseo_tts_with_counts) ?> categorie</em> in cui sono stati raggruppati.<br /><br />
  Selezionane uno: troverai tutto quello che succede in parlamento sull'argomento e i politici che se ne occupano.</p>
  </div>

    <?php echo include_partial('deppTagging/searchWithAutocompleter', array('name' => 'search_tag','tag_count'=>$tag_count)); ?>

    <h5 class="subsection">... oppure naviga le <?php echo count($teseo_tts_with_counts) ?> categorie</h5> 

    <div id="top_terms_drill_down" class="W73_100 float-left">
      <ul class="topics-list">
        <?php foreach ($teseo_tts_with_counts as $term_id => $term_data ): ?>
          <li id="top_term_<?php echo $term_id;?>" class="top_term">
            <?php echo link_to($term_data['denominazione'] .  " (" . $term_data['counter'] .  ")", '#') ?>
            <?php /* if ($term_data['n_monitored']>0): ?>
              <span class="ico-monitoring-left">(
                <?php echo $term_data['n_monitored'] ?>
              )</span>              
            <?php endif */ ?>
            <ul id="top_term_tags_<?php echo $term_id;?>" style="display:none"><li> </li></ul>
          </li>
        <?php endforeach ?>
  		</ul>
  <br />		
    </div>

  </div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  argomenti
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
        var url = "<?php echo url_for('@argomenti_per_categoria'); ?>";
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
