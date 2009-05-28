<?php use_helper('Date', 'I18N') ?>

<?php include_partial('atto_tabs', array('atto' => $atto, 'current' => 'commenti', 'nb_comments' => $atto->getNbPublicComments())) ?>

<div id="content" class="tabbed float-container">
  <a name="top"></a>
  <div id="main">
    <div class="W73_100 float-left">
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