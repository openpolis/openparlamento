<?php use_helper('Date', 'I18N') ?>

<?php include_partial('tabs', array('emendamento' => $emendamento, 'current' => 'commenti', 
                                    'nb_comments' => $emendamento->getNbPublicComments())) ?>

<div class="row">
	<div class="ninecol">
		
		<a name="top"></a>
		
		<p style="font-size:16px;">In questa pagina puoi lasciare commenti sull'emendamento.<br /></p>
	      <div id="comments-block">
	        <a name="comments"></a>
	        <?php include_partial('deppCommenting/commentsList', array('content' => $emendamento)) ?>

		      <hr/>

	        <?php include_component('deppCommenting', 'addComment', 
	                                array('content' => $emendamento,
	                                      'read_only' => sfConfig::get('app_comments_enabled', false),
	                                      'automoderation' => sfConfig::get('app_comments_automoderation', 'captcha')) ) ?>

	        <hr/>
	      </div>
		
	</div>
	<div class="threecol last"></div>
</div>

<?php slot('breadcrumbs') ?>
    <?php echo link_to("home", "@homepage") ?> /
    <?php include_partial('atto/breadcrumbsAtti', array('atto' => $attoPortante)) ?> /
    <?php echo link_to(Text::denominazioneAttoShort($attoPortante), '@singolo_atto?id=' . $attoPortante->getId() ) ?> /
    <?php echo link_to('Emendamenti', '@emendamenti_atto?id='.$attoPortante->getId()) ?> /
    <?php echo link_to('Emendamento ' . $emendamento->getTitolo(), '@singolo_emendamento?id='.$emendamento->getId()) ?> /
    Commenti
<?php end_slot() ?>
