<?php use_helper('I18N') ?>
<div id="content" class="tabbed float-container">
  <a name="top"></a>
  <div id="main">
    <div class="W73_100 float-left">
    <p style="font-size:16px;">Correggi l'errore e invia il commento.<br />
</p>
      <div id="comments-block">
        <?php include_component('deppCommenting', 'addComment',  
                                array('content' => $content, 
                                      'original_url' => $original_url,
                                      'read_only' => sfConfig::get('app_ddl_comments_enabled', false),
                                      'automoderation' => sfConfig::get('app_ddl_comments_automoderation', 'captcha')) ) ?>
        <hr/>
      </div>    

    </div>
  </div>
</div>