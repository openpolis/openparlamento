<?php use_helper('Date', 'I18N') ?>

<div class="row">
	<div class="twelvecol">
		<?php include_partial('atto_tabs', array('atto' => $atto, 'current' => 'commenti', 
		                                         'nb_comments' => $atto->getNbPublicComments(),
		                                         'nb_emendamenti' => $atto->countOppAttoHasEmendamentos())) ?>
	</div>
</div>

<div class="row">
	<div class="ninecol">
		
		<p style="font-size:16px;">In questa pagina puoi lasciare commenti generali sull'atto.<br />
	    Se invece vuoi <em class="open"><strong>aggiungere le tue note ai testi ufficiali</strong></em> dell'atto, vai alla sezione <?php echo link_to('"leggi i testi ufficiali dell\'atto e aggiungi le tue note"','/singolo_atto/'.$atto->getId().'#documenti') ?></p>


	    <?php /* 
	    <div><?php echo url_for('commenti_atto/'.$atto->getId(), true); ?></div>
	    <div id="disqus_thread"></div>
	    <script type="text/javascript">
	        // CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE //
	        var disqus_shortname = 'openparlamento'; // required: replace example with your forum shortname

	        // The following are highly recommended additional parameters. Remove the slashes in front to use.
	        var disqus_identifier = 'unique_dynamic_id_<?php echo $atto->getId() ?>';
	        var disqus_url = "<?php echo url_for('commenti_atto/'.$atto->getId()); ?>"
	        var disqus_developer = 1;

	        // DON'T EDIT BELOW THIS LINE //
	        (function() {
	            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
	            dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
	            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
	        })();
	    </script>
	    <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
	    <a href="http://disqus.com" class="dsq-brlink">blog comments powered by <span class="logo-disqus">Disqus</span></a>      

	    */ ?>

	    <div id="comments-block">
	      <a name="comments"></a>
	      <?php include_partial('deppCommenting/commentsList', array('content' => $atto)) ?>

	      <hr/>

	      <?php include_component('deppCommenting', 'addComment', 
	                              array('content' => $atto,
	                                    'read_only' => sfConfig::get('app_comments_enabled', false),
	                                    'automoderation' => sfConfig::get('app_comments_automoderation', 'captcha')) ) ?>

	      <hr/>
	    </div>
		
	</div>
	<div class="threecol last">
		
		
	</div>
</div>

