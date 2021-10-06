<?php use_helper('Date', 'sfRating') ;
slot('canonical_link');
echo "\n<link rel=\"canonical\" href=\"". url_for('@votazione?'. $votazione->getUrlParams() , true) ."\" />";
end_slot();
?>

<?php include_partial('votazione_tabs', array('votazione' => $votazione, 'current' => 'votazione', 'nb_comments' => $votazione->getNbPublicComments(), 'ramo' => $ramo)) ?>

<div class="row">
	<div class="ninecol">
		<a name="top"></a>

		<p class="synopsis">
		<?php echo $votazione->getTitolo() ?>
		</p>

		<ul class="presentation float-container"> 
			<li>
			<!-- bottone facebook -->
			<span style="vertical-align:top;"><a name="fb_share" type="button_count" href="http://www.facebook.com/sharer.php">condividi</a><script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script></span>
			</li>  
			<?php if($votazione->getUrl()): ?>
			<li><?php echo link_to("link alla fonte ufficiale", $votazione->getUrl(), array('class' => 'external', 'target' => '_blank')) ?></li>
			<?php endif; ?>		  
		</ul> 

		<?php if ($voto_atti || $voto_ems): ?> 
			<?php if (count($voto_atti)>1 || $voto_ems>1): ?>
			  <h5 class="subsection">la votazione si riferisce agli atti:</h5>
			<?php else : ?>   
			  <h5 class="subsection">la votazione si riferisce all'atto:</h5>
			<?php endif; ?>    
			<?php include_partial('atti', array( 'voto_atti' => $voto_atti,'voto_ems' => $voto_ems)) ?>  
		<?php endif; ?> 





		<h5 class="subsection">come hanno votato i gruppi</h5>
		<?php include_partial('gruppi', array('votazione' => $votazione, 'risultati' => $risultati)) ?> 

	</div>  
	
	<div class="threecol last">
		
		
		 <!-- blocco voting -->
	     <?php if ($sf_user->isAuthenticated() && ($sf_user->hasCredential('amministratore') || $sf_user->hasCredential('adhoc'))): ?>
	       <?php include_component('deppVoting', 'votingBlock', array('object' => $votazione)) ?>
	       <hr class="dotted" />
	     <?php endif ?>

	     <!-- blocco voti chiave -->
	     <?php if ($sf_user->isAuthenticated() && $sf_user->hasCredential('amministratore')): ?>
	       <div>
			<h6 class="slider-button">Lancia come relevant-vote</h6>
	       <?php echo include_partial('deppLaunching/launcher', array('object' => $votazione, 'namespace' => 'relevant_vote', 'options' => array('id' => 'relevant_vote'))); ?>    
			</div>
	        <br />
	       <hr class="dotted" />
			<div>
			       <h6 class="slider-button">Lancia come key-vote</h6>
			       <?php echo include_partial('deppLaunching/launcher', array('object' => $votazione, 'namespace' => 'key_vote', 'options' => array('id' => 'key_vote'))); ?>   
			</div>
	        <br />
	       <hr class="dotted" />

	<?php use_javascript('/js/jquery-ui-1.8.16.sortable.min.js'); ?>

	<script type="text/javascript">
		/* when the DOM is ready */

		/* jQuery UI used for drag and dropping admin elements */
		jQuery(document).ready(function() {

			jQuery('h6.slider-button').click(function(){
				jQuery(this).parent().find('.vote-administration').slideToggle();
			});

			jQuery('.vote-administration')
				.hide()
				.sortable({
					placeholder: 'vote-administration-highlight',
					update: function(event , ui)
					{
						var diff = ui.item.index() - ui.item.data('old-index');
						var action;
						if ( diff > 0 ) { action = jQuery('.movedown-vote', ui.item ); }
						else { action = jQuery('.moveup-vote', ui.item ); diff = -1 * diff; }
						jQuery.ajax({
							type: 'get',
							url: action.attr('href') +'/paths/'+ diff,
							complete: function() { ui.item.effect('highlight', {}, 3000); }
						});
					},
					start: function( e, ui ) {
						ui.item.data('old-index', ui.item.index() );
					}
				})
				.disableSelection()
				.find('a')
				.click(function(event){
					event.preventDefault();
					var action = jQuery(this);
					var container = action.parent().parent();
					switch ( action.attr('class') )
					{
						case 'moveup-vote' : container.prev().before(container);
							break;
						case 'movedown-vote' : container.next().after(container);
							break;
						case 'remove-vote' : container.remove();
							break;
					}
					jQuery.ajax({
						type: 'get',
						url: action.attr('href'),
						complete: function() { container.effect('highlight', {}, 3000); }
					});
				});
		});

	</script>


	     <?php endif ?>



	    <div style="background-color:#f7f7ff; padding: 5px;">
	     <div style="background-color:#fff; padding:5px; color:#828199; font-weight:bold; font-size:15px; border: 1px solid #e4e4e8;">esito della votazione</div>
	     <div style="padding: 5px;">
	     <?php if (($votazione->getEsito()=='APPROVATA') && (strtolower($votazione->getTitolo())!='votazione annullata')) : ?>
	          <?php echo image_tag('ico-votazione-yes.png', array('style' => 'vertical-align: middle; padding: 0 8px 0 0')) ?>	
	          <span style="background-color: #39aa2d; color:white; font-weight:bold; font-size:16px; padding: 5px;"><?php echo $votazione->getEsito() ?></span>
	      <?php else : ?>
	          <?php if (strtolower($votazione->getTitolo())!='votazione annullata') : ?>
	             <?php echo image_tag('ico-votazione-no.png', array('style' => 'vertical-align: middle; padding: 0 8px 0 0')) ?>	
	             <span style="background-color: #e10032; color:white; font-weight:bold; font-size:16px; padding: 5px;"><?php echo $votazione->getEsito() ?></span>
	           <?php else : ?> 
	             <div style="padding: 5px;"><span style="background-color: #e10032; color:white; font-weight:bold; font-size:16px; padding: 5px;">ANNULLATA</span></div> 
	           <?php endif ?> 
	      <?php endif ?>    

	      <div style="border-bottom:1px dotted #4E8480; padding:10px 5px 5px 10px;"></div>
	    </div>
	     <div style="padding: 5px">
	       <?php echo ($votazione->getIsMaggioranzaSottoSalva()==1?'<div style="background-color:white; padding:10px; margin-bottom:5px; font-weight:bold; font-size:14px;">'.image_tag('punto_esclamativo_rosso.png',array('align'=>'top')).' Maggioranza battuta</div>':'')?>
	       <?php echo ($votazione->getIsMaggioranzaSottoSalva()==2?'<div style="background-color:white; padding:10px; margin-bottom:5px; font-weight:bold; font-size:14px;">'.image_tag('punto_esclamativo_rosso.png',array('align'=>'top')).' Maggioranza salvata</div>':'')?>
	     <div style="background-color:white; padding:5px; font-weight:bold; font-size:16px; color:#39aa2d;">FAVOREVOLI: <?php echo $votazione->getFavorevoli()." (".round($votazione->getFavorevoli()*100/($votazione->getFavorevoli()+$votazione->getContrari()+$votazione->getAstenuti()),1)."%)" ?></div>
	      <br />
	      <div style="background-color:white; padding:5px; font-weight:bold; font-size:16px; color:#e10032;">CONTRARI: <?php echo $votazione->getContrari()." (".round($votazione->getContrari()*100/($votazione->getFavorevoli()+$votazione->getContrari()+$votazione->getAstenuti()),1)."%)" ?></div>
	      <br />
	      <div style="background-color:white; padding:5px; font-weight:bold; font-size:16px;">ASTENUTI: <?php echo $votazione->getAstenuti()." (".round($votazione->getAstenuti()*100/($votazione->getFavorevoli()+$votazione->getContrari()+$votazione->getAstenuti()),1)."%)" ?></div>
	      <br />
	      <div style="background-color:white; padding:5px; font-weight:bold; font-size:14px;">voti di scarto: <?php echo $votazione->getMargine() ?></div> 

	       <br />
	       <?php if ($votazione->getRibelli()>0): ?>
	          <div style="background-color:white; padding:5px; font-weight:bold; font-size:14px;">parlamentari ribelli: <a href="#ribelli"><?php echo $votazione->getRibelli() ?></a></div>
	          <div style="border-bottom:1px dotted #4E8480; padding:10px 5px 5px 10px;"></div>
	       <?php endif; ?>
	     </div>  	




	      <br /><br />
	             <?php echo include_component('votazione','chartPresenze', array('votazione' => $votazione, 'votantiComponent' => $votantiComponent, 'ramo' => $ramo)) ?>
	       <?php //echo include_component('votazione','chartEsito', array('votazione' => $votazione)) ?>

	       <br />

	    </div>
		
		
	</div>
	
</div>

<?php if ($ribelli): ?>
<div class="row">
	<div class="sevencol">
		<a name="ribelli"></a>
		<?php include_partial('ribelli', array('ribelli' => $ribelli, 'voto_gruppi' => $voto_gruppi)) ?>
		
	</div>
	<div class="fivecol last">
		
		<?php echo include_component('votazione','chartRibelli', array('votazione' => $votazione, 'ribelli' => $ribelli)) ?>
	</div>
</div>
<?php endif; ?>

<div class="row">
	<div class="sevencol">
		<h5 class="subsection">come hanno votato tutti i <?php echo ($ramo=='Camera' ? 'deputati' : 'senatori') ?></h5>
		<p style="margin-bottom:10px;">
		<?php echo ($votazione->getRibelli()>0?image_tag('ribelle_rosso.png', array('align'=>'middle')).'&nbsp;voto ribelle&nbsp;&nbsp;':'')?>
		<?php echo ($votazione->getIsMaggioranzaSottoSalva()==1?image_tag('punto_esclamativo_rosso.png',array('align'=>'middle')).'&nbsp;manda la maggioranza sotto':'')?>
		<?php echo ($votazione->getIsMaggioranzaSottoSalva()==2?image_tag('punto_esclamativo_rosso.png',array('align'=>'middle')).'&nbsp;salva la maggioranza':'')?>
		</p>
		<?php include_partial('votanti', array('votanti' => $votanti)) ?>	
		
	</div>
	<div class="fivecol last">
		<?php echo include_component('votazione','chartFavorevoli', array('votazione' => $votazione, 'risultati' => $risultati, 'votantiComponent' => $votantiComponent, 'ramo' => $ramo)) ?>
		
	</div>
</div>

 
<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  <?php echo link_to('votazioni', '@votazioni') ?>
    /
  <?php $votazione = OppVotazionePeer::retrieveByPk($sf_params->get('id')); ?>
  <?php echo $votazione->getTitolo(); ?>
<?php end_slot() ?>

<script type="text/javascript" charset="utf-8">
  jQuery.noConflict();
   jQuery(document).ready(function($) { 
     $("#complete-chart").tablesorter({
       sortList: [[0, 0]], 
       widgets: ['zebra']
     }); 
   });  
 </script>
