<?php use_helper('I18N') ?>


<?php if (!$canView): ?>
  <p class="wiki-warning"><?php echo __('Per modificare la descrizione e\' necessario registrarsi') ?></p>
<?php else: ?>
<p style="font-size:16px;">In questa pagina puoi <strong>descrivere</strong> l'atto per meglio farlo comprendere agli altri utenti.<br />
Se invece vuoi lasciare un tuo commento, vai nella apposita pagina dei commenti all'atto.</p>
<p>Questo &egrave; un sistema wiki. Puoi scrivere e salvare (tasto "pubblica la modifica" in basso) la tua descrizione o modificare il testo eventualmente scritto da altri utenti.<br /> Tutte le modifiche vengono registrate automaticamente e possono essere verificate facendo click sul tab "Cronologia delle modifiche". </p>
  <?php if (!$revision->isLatest()): ?>
    <p class="wiki-warning">
      <?php echo __('You are currently editing an old revision of this page. If you save these changes, all changed made since this revision will be lost !!') ?> 
      <?php echo link_to(__('Don\'t you want to edit the latest version of this page ?'), 'nahoWiki/edit?page=' . $page->getName()) ?>
    </p>
  <?php endif ?>

  

    <?php if ($canEdit): ?>
      <?php if (!$sf_user->isAuthenticated()): ?>
        <p><?php echo __('You are not authenticated. Your IP address will be stored : %ip%.', array('%ip%' => '<strong>' . $userName . '</strong>')) ?></p>
      <?php else: ?>
        <p><?php echo __('You are authenticated. Your username will be stored : %username%.', array('%username%' => '<strong>' . $userName . '</strong>')) ?></p>
      <?php endif ?>
    <?php endif ?>
    <div class="W48_100 float-right">

		  <h5 class="subsection-alt">anteprima della modifica</h5>
		
			<script type="text/javascript">
			//<![CDATA[
			
			  wmd_options = {
					// format sent to the server.  Use "Markdown" to return the markdown source.
					output: "Markdown",
			
					// line wrapping length for lists, blockquotes, etc.
					lineLength: 60,
			
					// toolbar buttons.  Undo and redo get appended automatically.
					buttons: "bold italic heading hr | link blockquote  | ol ul ",
			
					// option to automatically add WMD to the first textarea found.  See apiExample.html for usage.
					autostart: true
				};
			
			//]]>
			</script>
			<div id="wmd-preview" class="evidence-box bg-light-cyan pad10">
			  <p>
			     <script type="text/javascript" language="javascript" src="/js/wmd/wmd.js"></script>
			  </p>
		  </div>
    </div>
    
    <div class="W50_100 float-left">
    

      <?php echo form_tag('nahoWiki/edit?' . $uriParams, 'name=edit_page id=edit_page') ?>
  		  <div class="evidence-box">
  			  <p><?php echo textarea_tag('content', $revision->getContent(true), 'size=50x20 class=wikicontent' . ($canEdit ? '' : ' readonly=yes')) ?></p>
  		  </div>
	
  		  <p class="wiki-form-submit">
          <?php if ($canEdit): ?>
            <?php echo submit_tag(__('pubblica la modifica'), 'class=commit') ?> |
    			<?php endif ?>	
    			<?php echo link_to(__('annulla'), $sf_user->getAttribute('referer', '@homepage')) ?>
  		  </p>     
      </form>

    </div>
	
     



  <?php if ($sf_request->getParameter('request-preview')): ?>
    <p class="wiki-warning"><?php echo __('This is a preview of how your text will look like. Remember: <strong>It is not saved yet</strong> !') ?></p>
    <?php include_partial('content', array('preview' => true, 'revision' => $revision, 'uriParams' => $uriParams)) ?>
  <?php endif ?>

<?php endif ?>