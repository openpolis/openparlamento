<?php use_helper('Date', 'I18N') ?>

<?php include_partial('atto_tabs', array('atto' => $atto, 'current' => 'commenti', 
                                         'nb_comments' => $atto->getNbPublicComments(),
                                         'nb_emendamenti' => $atto->countOppAttoHasEmendamentos())) ?>

<div id="content" class="tabbed float-container">
  <a name="top"></a>
  <div id="main">
    <div class="W73_100 float-left">
    <p style="font-size:16px;">In questa pagina puoi lasciare commenti generali sull'atto.<br />
    Se invece vuoi <em class="open"><strong>aggiungere le tue note ai testi ufficiali</strong></em> dell'atto, vai alla sezione <?php echo link_to('"leggi i testi ufficiali dell\'atto e aggiungi le tue note"','/singolo_atto/'.$atto->getId().'#documenti') ?></p>
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
  </div>
</div>