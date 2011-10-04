<?php use_helper('Date', 'I18N') ?>

<?php include_partial('votazione_tabs', array(
               'votazione' => $votazione, 'current' => 'commenti', 'nb_comments' => $votazione->getNbPublicComments(), 'ramo' => $ramo)) ?>

<div id="content" class="tabbed float-container">
  <a name="top"></a>
  <div id="main">
    <div class="W73_100 float-left">
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
  </div>
</div>