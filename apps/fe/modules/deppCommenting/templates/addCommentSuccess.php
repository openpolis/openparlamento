<?php use_helper('I18N') ?>

<div class="row">
	<div class="twelvecol">
		<a name="top"></a>
		<p style="font-size:16px;">Correggi l'errore e invia il commento.<br /></p>
	      <div id="comments-block">
	        <?php include_component('deppCommenting', 'addComment',  
	                                array('content' => $content, 
	                                      'original_url' => $original_url,
	                                      'read_only' => sfConfig::get('app_deppPropelActAsCommentableBehaviorPlugin_enabled', false),
	                                      'automoderation' => sfConfig::get('app_deppPropelActAsCommentableBehaviorPlugin_automoderation', 'captcha')) ) ?>
	        <hr/>
	      </div>
		
	</div>
</div>