<?php include_partial('tabs',array('ramo' => 'camera','gruppi'=> false, 'organi' => true)) ?>

<div class="row">
	<div class="twelvecol">
		
		<?php echo include_partial('secondLevelMenuOrgani', 
	                               array('current' => 'commissioni',
	                               'ramo' => 'camera')); ?>


	    <div id="accordion">
	      <?php foreach ($comms as $comm) : ?>
	          <?php echo include_component('parlamentare','commissioniPermanenti',array('sede_id' => $comm->getId(),'leg' => 18)) ?>
	      <?php endforeach; ?>
	    </div>
	
	</div>
</div> 

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  <?php echo link_to("organi della camera", "@organi?ramo=camera") ?>/
    commissioni permanenti  
<?php end_slot() ?>           
                    
<!-- slider jQuery per i componenti -->
<script type="text/javascript">
//<![CDATA[

jQuery.noConflict();
(function($) {
  $().ready(function(){

    $('#accordion').accordion({
      icons: { 'header': 'btn-open-section', 'headerSelected': 'btn-close-section' },
      collapsible: true,
      navigation: true,
      animated: 'easeslide'
    });
    
     $('li a.show-hide-dettaglio').click(
      	function(){
      	  $this = $(this);

      		var parent_li = $this.parents('li');
          var url = $this.attr('href');
          if (!$this.data('details_loaded'))
          {
            parent_li.append("<div style=\"margin-left: 1.5em;\"></div>");
            parent_li.children("div").load(url);
            $this.text('nascondi');
            $this.data('details_loaded', true);
          } else {
            parent_li.children("div").remove();
            $this.data('details_loaded', false);
            $this.text('mostra');
          }
          return false;
      	}
      );

    	// Setup the ajax indicator
    	$("body").append('<div id="ajaxBusy"><p><img src="/images/loading.gif"></p></div>');

    	$('#ajaxBusy').css({
    		display:"none",
    		padding:"0px",
    		position:"absolute",
    		right:"0px",
    		top:"0px",
    		left:"0px",
    		bottom:"0px",
    		margin:"auto",
    		width:"40px",
    		height:"40px"
    	});

    	// Ajax activity indicator bound 
    	// to ajax start/stop document events
    	$(document).ajaxStart(function(){ 
    		$('#ajaxBusy').show(); 
    	}).ajaxStop(function(){ 
    		$('#ajaxBusy').hide();
    	});
    

  })
})(jQuery);

//]]>
		
</script>
