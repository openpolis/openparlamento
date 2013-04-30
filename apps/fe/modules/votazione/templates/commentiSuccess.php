<?php use_helper('Date', 'I18N');
slot('canonical_link');
echo "\n<link rel=\"canonical\" href=\"". url_for('@commenti_votazione?'. $votazione->getUrlParams() , true) ."\" />";
end_slot();
?>

<?php include_partial('votazione_tabs', array(
               'votazione' => $votazione, 'current' => 'commenti', 'nb_comments' => $votazione->getNbPublicComments(), 'ramo' => $ramo)) ?>

<div class="row">
	<div class="ninecol">
		<a name="top"></a>
		<p style="font-size:16px;">In questa pagina puoi lasciare commenti relativi alla votazione.</p>
	      <div id="comments-block">
	        <a name="comments"></a>
	        <?php include_partial('deppCommenting/commentsList', array('content' => $votazione)) ?>

		      <hr/>

	        <?php include_component('deppCommenting', 'addComment', 
	                                array('content' => $votazione,
	                                      'read_only' => sfConfig::get('app_comments_enabled', false),
	                                      'automoderation' => sfConfig::get('app_comments_automoderation', 'captcha')) ) ?>

	        <hr/>
	      </div>
		
	</div>
	<div class="threecol last"></div>
</div>
